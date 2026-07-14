<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function show()
    {
        $transactions = auth()->user()->transactions()->orderByDesc('created_at')->paginate(8);
        return view('profile.orders.transactions',compact('transactions'));
    }
    public function showInPanel()
    {
        $transactions = Transaction::latest()->with(['order.items.product','order.address','user'])->paginate(8);
//        dd($transactions);
        return view('panel.orders.transactions',compact('transactions'));
    }
}
