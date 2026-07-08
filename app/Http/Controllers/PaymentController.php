<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
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
            return redirect()->back()->with('warning', 'سبد خرید با موجودی انبار سازگار شد.');
        }

        $user_id = auth()->id();
        $cart_items = Cart::with('product')->where('user_id', $user_id)->get();

        $total_price = 0;
        foreach ($cart_items as $cart_item) {
            if ($cart_item->product->is_sale) {
                $total_price += $cart_item->product->sale_price * $cart_item->qty;
            } else {
                $total_price += $cart_item->product->price * $cart_item->qty;
            }
        }
        $coupon = $request->session()->get('coupon');

        if ($coupon) {
            $db_coupon = Coupon::where('code', $coupon['code'])->first();
            if (!$db_coupon || $db_coupon->expired_at < Carbon::now('Asia/Tehran')) {
                $request->session()->remove('coupon');
                return redirect()->route('cart')->with('warning', 'کد تخفیف حذف شده است.');
            }
            if (Order::where('user_id', $user_id)->where('coupon_id', $db_coupon->id)->where('payment_status', 1)->exists()) {
                return redirect()->back()->with('warning', 'شما قبلا از این کد تخفف استفاده کرده اید.');
            }

            $coupon_amount = $total_price * $coupon['percent'] / 100;
            $final_price = $total_price - $coupon_amount;
        } else {
            $final_price = $total_price;
        }
//        dd($total_price, $final_price, $coupon_amount);

        $response = $this->sendRequestToZarinPal($final_price);

        $response_data = $response->data;
        return redirect()->to("https://sandbox.zarinpal.com/pg/StartPay/$response_data->authority");

    }

    public function sendRequestToZarinPal($amount)
    {

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
  "amount": '.$amount.',
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
        $status = $request->Status;
        return view('app.payment.index',compact('status'));
    }

}

