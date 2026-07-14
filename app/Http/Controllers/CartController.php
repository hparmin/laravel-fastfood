<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Coupon;
use App\Models\product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $validated = $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'qty' => 'nullable|int|min:1',
        ]);

        $qty = intval($validated['qty'] ?? 1);
        $product = Product::findOrFail($validated['product_id']);

        if ($qty > $product->quantity) {
            return redirect()->back()->with('error', "تعداد درخواستی بیش از موجودی انبار میباشد. موجودی انبار: {$product->quantity} عدد"
            );
        }
        $sessionId = $request->session()->getId();
        $userId = auth()->id();

        try {
            DB::transaction(function () use ($product, $qty, $sessionId, $userId) {
                $query = Cart::withTrashed()
                    ->where('product_id', $product->id);
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->whereNull('user_id')
                        ->where('session_id', $sessionId);
                }

                $cartItem = $query->first();

                if (!$cartItem) {
                    Cart::create([
                        'user_id' => $userId,
                        'session_id' => $sessionId,
                        'product_id' => $product->id,
                        'qty' => $qty,
                    ]);

                    return;
                }

                if ($cartItem->trashed()) {
                    $cartItem->restore();
                    $cartItem->update([
                        'user_id' => $userId,
                        'session_id' => $sessionId,
                        'qty' => $qty,
                    ]);

                    return;
                }

                $newQty = $cartItem->qty + $qty;

                if ($newQty > $product->quantity) {
                    throw new \RuntimeException(
                        "تعداد درخواستی بیش از موجودی انبار میباشد. موجودی انبار: {$product->quantity} عدد"
                    );
                }

                $cartItem->increment('qty', $qty);
            });
        } catch (\RuntimeException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with([
            'success' => "{$product->name} با موفقیت به سبد خرید اضافه شد.",
        ]);
    }

    public function decrement(Request $request)
    {
        $this->AdjustmentCart($request);

        $validated = $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'qty' => 'nullable|int|min:1',
        ]);

        $qty = intval($validated['qty'] ?? 1);
        $product = Product::findOrFail($validated['product_id']);

        $sessionId = $request->session()->getId();
        $userId = auth()->id();

        $query = Cart::where('product_id', $product->id);

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->whereNull('user_id')
                ->where('session_id', $sessionId);
        }

        $cartItem = $query->first();


        if ($qty == $cartItem->qty) {
            return redirect()->back()->with(["error" => 'تعداد حذف غیر مجاز.']);
        }

        if (!$cartItem) {
            return redirect()->back()->with([
                'warning' => 'محصول در سبد شما یافت نشد.',
            ]);
        }

        if ($qty >= $cartItem->qty) {
            $cartItem->delete();

            return redirect()->back()->with([
                'warning' => "{$product->name} با موفقیت از سبد خرید حذف شد.",
            ]);
        }

        $cartItem->decrement('qty', $qty);

        return redirect()->back()->with([
            'warning' => "{$product->name} با موفقیت از سبد خرید کم شد.",
        ]);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        $product_name = $cart->product->name;
        return redirect()->back()->with(['warning' => "$product_name با موفقیت از سبد حذف شد"]);
    }

    public function cart(Request $request)
    {
//        $request->session()->remove('coupon');
//        dd($request->session()->get('coupon'));


        $coupon = 0;
        $coupon = $request->session()->get('coupon');

        $session_id = $request->session()->getId();
        $user_id = auth()->id();

        if (isset($coupon['code'])) {
            $db_coupon = Coupon::where('code', $coupon['code'])->first();
            if (!$db_coupon) {
                return redirect()->route('coupon.destroy.session');
            }
            if ($db_coupon->expired_at < Carbon::now('Asia/Tehran')){
                return redirect()->route('coupon.destroy.session');
            }
        }

        $query = Cart::with('product');

        if ($user_id) {
            $query->where('user_id', $user_id);
        } else {
            $query->where('session_id', $session_id);
        }
        $cart_items = $query->get();

        $before_off_payment = 0;
        $after_off_payment = 0;
        foreach ($cart_items as $cart_item) {
            if ($cart_item->product->is_sale) {
                $after_off_payment += $cart_item->product->sale_price * $cart_item->qty;
            } else {
                $after_off_payment += $cart_item->product->price * $cart_item->qty;
            }
            $before_off_payment += $cart_item->product->price * $cart_item->qty;
        }

        if ($user_id) {
            $addresses = auth()->user()->addresses;
        } else {
            $addresses = null;
        }
        $addresses = $addresses->isEmpty() ? null : $addresses;

        return view('profile.cart.index', compact('cart_items', 'before_off_payment', 'after_off_payment', 'addresses', 'coupon'));
    }

    public function deleteCart(Request $request)
    {
        $session_id = $request->session()->getId();
        $user_id = auth()->id();

        if ($user_id) {
            $query = Cart::where('user_id', $user_id);
        } else {
            $query = Cart::where('session_id', $session_id);
        }
        $query->delete();
        return redirect()->back()->with(["warning" => "کل سبد خرید حذف شد"]);
    }

    public function test(Request $request)
    {
        $session_id = $request->session()->getId();
        if (auth()->check()) {
            $cartCount = Cart::where('user_id', auth()->id())
                ->count();
        } else {
            $cartCount = Cart::where('session_id', $session_id)
                ->count();
        }
        var_dump($cartCount);
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
