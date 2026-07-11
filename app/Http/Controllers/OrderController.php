<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public static function create_order($cart_items, $user_id, $address_id, $coupon, $amount, $token)
    {

        DB::beginTransaction();
        $order = Order::create([
            'user_id' => $user_id,
            'address_id' => $address_id,
            'coupon_id' => $coupon == null ? null : $coupon->id,
            'total_amount' => $amount['total_amount'],
            'coupon_amount' => $amount['coupon_amount'],
            'paying_amount' => $amount['final_price'],
        ]);
        foreach ($cart_items as $item) {
            $item_price = $item->product->is_sale ? $item->product->sale_price : $item->product->price;
            $subtotal = $item_price * $item->qty;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'price' => $item_price,
                'quantity' => $item->qty,
                'subtotal' => $subtotal,
            ]);
        }
        Transaction::create([
            'user_id' => $user_id,
            'order_id' => $order->id,
            'amount' => $amount['final_price'],
            'token' => $token,
        ]);
        DB::commit();
    }

    public static function update_order($token, $ref_number)
    {
        $transaction = Transaction::where('token', $token)
            ->whereIn('status', [0])
            ->first();

        if ($transaction) {
            DB::beginTransaction();

                $transaction->update([
                    'status' => 1,
                    'ref_number' => $ref_number,
                ]);
                $order = Order::where('id', $transaction->order_id)->first();
                $order->update([
                    'status' => 1,
                    'payment_status' => 1
                ]);
                $order_items = $order->items;
                foreach ($order_items as $order_item) {
                    $product = Product::where('id', $order_item->product_id)->first();
                    $product->update([
                        'quantity' => $product->quantity - $order_item->quantity,
                    ]);
                }

                $user_id = auth()->id();
                $query = Cart::where('user_id', $user_id);
                $query->delete();

            DB::commit();

            session()->remove('coupon');
        }
    }

    public function showInPanel()
    {
        $orders = Order::latest()->with(['address','items','coupon'])->paginate(4);
//        dd($orders);
        return view('panel.orders.index',compact('orders'));
    }
}
