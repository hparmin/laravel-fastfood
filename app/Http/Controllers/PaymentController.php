<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    protected function CartAdjustment(Request $request)
    {
        $res = false;

        $user_id = auth()->id();

        $cart_items = Cart::with('product')->where('user_id', $user_id)->get();

        foreach ($cart_items as $item) {
            if ($item->qty > $item->product->quantity) {
                $item->qty = $item->product->quantity;
                $item->save();
                $res = true;
            }
        }
        return $res;

    }

    public function send(Request $request)
    {
        $request->validate([
            'address_id' => 'required|int|exists:user_adresses,id',
        ]);

        $check_cart = $this->CartAdjustment($request);
        if ($check_cart) {
            return redirect()->back()->with('warning', 'سبد خرید با موجودی انبار سازگار شد. اگر مورد تایید است روی پرداخت کلیک کنید.');
        }

        $user_id = auth()->id();
        $cart_items = Cart::with('product')->where('user_id', $user_id)->get();

        $total_price = 0;
        $coupon_amount = 0;
        foreach ($cart_items as $cart_item) {
            if ($cart_item->product->is_sale) {
                $total_price += $cart_item->product->sale_price * $cart_item->qty;
            } else {
                $total_price += $cart_item->product->price * $cart_item->qty;
            }
        }
        $coupon = $request->session()->get('coupon');

        $db_coupon = null;
        if ($coupon) {
            $db_coupon = Coupon::where('code', $coupon['code'])->first();
            if (!$db_coupon || $db_coupon->expired_at < Carbon::now('Asia/Tehran')) {
                $request->session()->remove('coupon');
                return redirect()->route('cart')->with('warning', 'کد تخفیف حذف شده است.');
            }
            if (Order::where('user_id', $user_id)->where('coupon_id', $db_coupon->id)->where('payment_status', 1)->exists()) {
                return redirect()->back()->with('warning', 'شما قبلا از این کد تخفف استفاده کرده اید.');
            }

            $coupon_amount = $total_price * $db_coupon->percentage / 100;
            $final_price = $total_price - $coupon_amount;
        } else {
            $final_price = $total_price;
        }

        $amount['total_amount'] = $total_price;
        $amount['coupon_amount'] = $coupon_amount;
        $amount['final_price'] = $final_price;

        $response = $this->sendRequestToZarinPal($final_price);
        $response_data = $response->data;

        OrderController::create_order($cart_items, $user_id, $request->address_id, $db_coupon, $amount, $response_data->authority);

        return redirect()->to("https://sandbox.zarinpal.com/pg/StartPay/$response_data->authority");

    }

    public function sendRequestToZarinPal($amount)
    {
//      toman to rial:
        $amount *= 10;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/request.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
  "merchant_id": "724eb0ec-4e3f-4e7a-aa1d-93a39e9ed7ac",
  "amount": ' . $amount . ',
  "callback_url": "http://127.0.0.1:8000/payment/verify",
  "referrer_id": "xxxx",
  "description": "buying product from arminhajipour.ir",
  "metadata": {
    "mobile": "09223017797",
    "email": "info.test@example.com"
  }
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
//        return redirect()->to("https://sandbox.zarinpal.com/pg/StartPay/$response_data->authority");
    }

    public function callback(Request $request)
    {
        $request->validate([
            'Status' => 'required',
            'Authority' => 'required|string',
        ]);
        $status = $request->Status ? $request->Status : false;

        $token = $request->Authority ? $request->Authority : false;

        $db_transaction = Transaction::where('token', $token)
//            ->where('status',0)
            ->first();
        if (!$db_transaction){
            return view('app.payment.index', compact('status'));
        }

        $transacion_response = $this->checkVerify($db_transaction->amount, $db_transaction->token);
        $data = $transacion_response->data;
        $errors = $transacion_response->errors;

        if (isset($data->code) && $data->code >= 100) {
            $ref_number = $data->ref_id;

            if ($data->code == 100){
                OrderController::update_order($token,$ref_number);
            }

            $db_transaction->update([
                'status' => 1,
                'ref_number' => $ref_number,
            ]);

            return view('app.payment.index', compact('status', 'ref_number'));
        }elseif (isset($errors->code)){
//            $message = $errors->message;
            $error_code = $errors->code;
            return view('app.payment.index', compact('status', 'error_code'));
        }

        return view('app.payment.index', compact('status'));
    }

    public function checkVerify($amount, $token)
    {
//        toman to rial:
        $amount *= 10;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
  "merchant_id": "724eb0ec-4e3f-4e7a-aa1d-93a39e9ed7ac",
  "amount": "'.$amount.'",
  "authority": "' . $token .'"
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);

    }
}
