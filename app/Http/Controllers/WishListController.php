<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\wishlist;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
        ]);

        if (!auth()->check()){
            return redirect()->back()->with('warning','برای دسترسی به لیست علاقه مندی باید وارد شوید.');
        }
        $user = auth()->user();

        $user_wishlist = wishlist::query()->where('user_id',$user->id)->where('product_id', $request->product_id)->first();
        if ($user_wishlist){
            return redirect()->back()->with('warning','این محصول در لیست علاقه مندی شما وجود دارد.');
        }

        wishlist::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
        ]);
        return redirect()->back()->with('success','محصول با موفقیت به لیست علاقه مندی اضافه شد.');
    }

    public function removeFromWishlist(Request $request)
    {

    }
}
