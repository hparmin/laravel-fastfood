<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sliders;
use App\Models\Feature;

class HomeController extends Controller
{
    public function index()
    {
        $features = feature::all();
        $sliders = Sliders::all();
        return view('app.index', compact('sliders','features'));
    }
}
