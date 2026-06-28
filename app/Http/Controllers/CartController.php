<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function AdjustmentCart(Request $request)
    {
        $cart = $request->session()->get('cart');
        $res = false;
        if (isset($cart) && !empty($cart)) {
            foreach ($cart as $product_id => $kay) {
                $product = product::findOrFail($product_id);
                if ($product->quantity < $cart[$product_id]['qty']) {
                    $cart[$product_id]['qty'] = $product->quantity;
                    $res = true;
                }
            }
            $request->session()->put('cart', $cart);
        }
        return $res;
    }

    public function increment(Request $request)
    {
        $this->AdjustmentCart($request);

        $request->validate([
            'product_id' => 'required|int|exists:products,id',
        ]);
        $qty = isset($request->qty) ? intval($request->qty) : 1;
        $product_id = $request->product_id;
        $product = product::findOrFail($product_id);

        $cart = $request->session()->get('cart', []);
        if (isset($cart[$product_id])) {
            if ($cart[$product_id]['qty'] + $qty > $product->quantity) {
                return redirect()->back()->with(['error' => 'تعداد درخواستی بیش از موجودی انبار میباشد.']);
            } else {
                $cart[$product_id]['qty'] += $qty;
            }
        } else {
            $cart[$product_id]['qty'] = $qty;
        }
        $request->session()->put('cart', $cart);

        return redirect()->back()->with(['success' => 'محصول با موفقیت به سبد خرید اضافه شد.']);
    }

    public function cart(Request $request)
    {
        dd($request->session()->get('cart'));
    }
}
