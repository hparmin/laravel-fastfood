<?php

namespace App\Http\Controllers;

use App\Models\aboutUs;
use App\Models\footer;
use Illuminate\Http\Request;
use App\Models\Sliders;
use App\Models\Feature;

class HomeController extends Controller
{
    public function index()
    {
        $footer = footer::first();
        $features = feature::all();
        $sliders = Sliders::all();
        $about_us = aboutUs::first();
        return view('app.index', compact('sliders','features','about_us','footer'));
    }
}
