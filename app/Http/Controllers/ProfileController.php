<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Order;
use App\Models\Province;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\wishlist;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return redirect()->back()->with('success', 'اطلاعات بروزرسانی شد.');
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses;
        return view('profile.addresses.index', compact('addresses'));
    }

    public function addresscreate()
    {
        $provinces = Province::all();
        $cities = City::all();
        return view('profile.addresses.create', compact('provinces', 'cities'));
    }

    public function addressStore(Request $request, User $user = null)
    {
        if ($user == null) {
            $user = auth()->user();
        }
        $request->validate([
            'title' => 'required|string',
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
            'postal_code' => ['required', 'regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string',
        ]);
        UserAddress::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);
        return redirect()->back()->with('success', 'آدرس با موفقیت ثبت شد.');
    }

    public function addressEdit(UserAddress $address)
    {
        $provinces = Province::all();
        $cities = City::all();
        return view('profile.addresses.edit', compact('address', 'cities', 'provinces'));
    }

    public function addressUpdate(UserAddress $address, Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
            'postal_code' => ['required', 'regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string',
        ]);
        $address->update([
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'آدرس بروزرسانی شد.');
    }

    public function addressesDestroy(UserAddress $address)
    {
        $address->delete();
        return redirect()->back()->with('success', 'آدرس مورد نظر حذف شد.');
    }

    public function showWishlist()
    {

//        $wishlist_id = auth()->user()->wishlist;

        $user = auth()->user();

        $wishlist = wishlist::query()->where('user_id', $user->id)->get();
        return view('profile.wishlist.index', compact('wishlist'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->orderByDesc('created_at')->with(['address','items'])->paginate(7);
//        foreach ($orders as $order){
//            dd($order->products);
//        }
        return view('profile.orders.index',compact('orders'));
    }
}
