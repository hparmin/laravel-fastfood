<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function AdjustmentCart(Request $request)
    {
        $res = false;

        $session_id = $request->session()->getId();
        $user_id = auth()->id();

        $query = Cart::with('product');

        if ($user_id) {
            $query->where('user_id', $user_id);
        } else {
            $query->where('session_id', $session_id);
        }
        $cart_items = $query->get();
        foreach ($cart_items as $item) {
            if ($item->qty > $item->product->quantity) {
                $item->qty = $item->product->quantity;
                $item->save();
                $res = true;
            }
        }
        return $res;

    }



    public function increment(Request $request)
    {
        $this->AdjustmentCart($request);
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'qty' => 'nullable|int|min:1'
        ]);

        $qty = $request->qty ? intval($request->qty) : 1;
        $product_id = $request->product_id;

        $product = Product::findOrFail($product_id);

        $session_id = $request->session()->getId();
        $user_id = auth()->id();

        $query = Cart::where('product_id', $product_id);

        if ($user_id) {
            $query->where('user_id', $user_id);
        } else {
            $query->where('session_id', $session_id);
        }
        $cartItem = $query->first();

        if ($cartItem) {
            if ($cartItem->qty + $qty <= $product->quantity) {
                $cartItem->increment('qty', $qty);
            } else {
                $product_quantity = $product->quantity;
                return redirect()->back()->with('error', "تعداد درخواستی بیش از موجودی انبار میباشد. موجودی انبار: $product_quantity عدد");
            }
        } else {
            if ($qty <= $product->quantity) {
                cart::create([
                    'user_id' => $user_id,
                    'session_id' => $session_id,
                    'product_id' => $product_id,
                    'qty' => $qty
                ]);
            } else {
                $product_quantity = $product->quantity;
                return redirect()->back()->with('error', "تعداد درخواستی بیش از موجودی انبار میباشد. موجودی انبار: $product_quantity عدد");
            }
        }
        $product_name = $product->name;
        return redirect()->back()->with(['success' => "$product_name با موفقیت به سبد خرید اضافه شد."]);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        $product_name = $cart->product->name;
        return redirect()->back()->with(['warning' => "$product_name با موفقیت از سبد حذف شد"]);
    }

    public function cart(Request $request)
    {
        $session_id = $request->session()->getId();
        $user_id = auth()->id();

        $query = Cart::with('product');

        if ($user_id) {
            $query->where('user_id', $user_id);
        } else {
            $query->where('session_id', $session_id);
        }
        $cart_items = $query->get();

        return view('profile.cart.index', compact('cart_items'));
    }






//    public function increment(Request $request)
//    {
//        $this->AdjustmentCart($request);
//
//        $request->validate([
//            'product_id' => 'required|int|exists:products,id',
//        ]);
//        $qty = isset($request->qty) ? intval($request->qty) : 1;
//        $product_id = $request->product_id;
//        $product = product::findOrFail($product_id);
//
//        $cart = $request->session()->get('cart', []);
//        if (isset($cart[$product_id])) {
//            if ($cart[$product_id]['qty'] + $qty > $product->quantity) {
//                return redirect()->back()->with(['error' => 'تعداد درخواستی بیش از موجودی انبار میباشد.']);
//            } else {
//                $cart[$product_id]['qty'] += $qty;
//            }
//        } else {
//            $cart[$product_id]['qty'] = $qty;
//        }
//        $request->session()->put('cart', $cart);
//
//        return redirect()->back()->with(['success' => 'محصول با موفقیت به سبد خرید اضافه شد.']);
//    }

}
