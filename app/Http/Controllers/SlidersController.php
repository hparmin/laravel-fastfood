<?php

namespace App\Http\Controllers;

use App\Models\Sliders;
use Illuminate\Http\Request;

class SlidersController extends Controller
{
    public function index()
    {
        $sliders = Sliders::all();
        return view('panel.slider.index',compact('sliders'));
    }

    public function edit(Sliders $slider)
    {
        return view('panel.slider.edit',compact('slider'));
    }
    public function destroy(Sliders $slider)
    {
        $slider->delete();
        return redirect()->route('slider.index')->with('warning','اسلایدر با موفقیت حذف شد.');
    }
    public function create()
    {
        return view('panel.slider.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'link_title' => 'required|string',
            'link_address' => 'required|string',
            'body' => 'required|string',
        ]);
        Sliders::create([
            'title' => $request->title,
            'link_title' => $request->link_title,
            'link_address' => $request->link_address,
            'body' => $request->body
        ]);
        return redirect()->route('slider.index')->with('success','اسلایدر با موفقیت ایجاد شد.');
    }
    public function update(Request $request, Sliders $slider)
    {
        $request->validate([
            'title' => 'required|string',
            'link_title' => 'required|string',
            'link_address' => 'required|string',
            'body' => 'required|string',
        ]);
        $slider->update([
            'title' => $request->title,
            'link_title' => $request->link_title,
            'link_address' => $request->link_address,
            'body' => $request->body
        ]);
        return redirect()->route('slider.edit',['slider' => $slider->id])->with('success','اسلایدر با موفقیت آپدیت شد.');
    }

}
