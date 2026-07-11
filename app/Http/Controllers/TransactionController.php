<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function show()
    {
        $orders = Order::latest()->with(['address','items','coupon'])->paginate(4);
//        dd($orders);
        return view('panel.orders.index',compact('orders'));
    }
}
