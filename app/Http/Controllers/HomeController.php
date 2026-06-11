<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sliders;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Sliders::all();
        return view('app.index', compact('sliders'));
    }
}
