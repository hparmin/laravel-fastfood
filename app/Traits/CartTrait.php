<?php

namespace App\Traits;

use App\Models\Cart;
use Illuminate\Http\Request;

trait CartTrait
{
    public function mergeCart($session_id,$user_id)
    {
//        $session_id = $request->session()->getId();
//        $user_id = auth()->id();
        $res = false;
        User::find($user_id);
        if ($user_id) {
            $cart_items = Cart::where('session_id', $session_id)
                ->whereNull('user_id')
                ->update(['user_id' => $user_id]);
            if ($cart_items) {
                $res = true;
            }
        }
        return $res;
    }
}
