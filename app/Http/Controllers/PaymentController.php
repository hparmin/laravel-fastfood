<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function send(Request $request)
    {
        $request -> validate([
            'address_id' => 'required|int|exists:user_adresses,id',
            'coupon_code' => 'nullable|string',
        ]);
        dd($request->all());
    }
}
