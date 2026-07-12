<?php

namespace App\Http\Controllers;

use App\Models\Order;

class TransactionController extends Controller
{
    public function show()
    {
        $transactions = auth()->user()->transactions()->orderByDesc('created_at')->paginate(8);
        return view('profile.orders.transactions',compact('transactions'));
    }
}
