<?php

namespace App\Http\Controllers;

use App\Models\aboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $item = aboutUs::first();
        return view('panel.about-us.index',compact('item'));
    }
    public function show()
    {
        $item = aboutUs::first();
        return view('app.about',compact('item'));
    }
    public function edit(aboutUs $about)
    {
        return view('panel.about-us.edit',compact('about'));
    }

    public function update(Request $request, aboutUs $about)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'link' => 'required|string'
        ]);
        $about->update([
            'title' => $request->title,
            'body' => $request->body,
            'link' => $request->link,
        ]);
        return redirect()->route('about.edit',['about' => $about->id])->with('success','درباره ما با موفقیت آپدیت شد.');
    }
}
