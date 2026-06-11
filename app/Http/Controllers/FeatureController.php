<?php

namespace App\Http\Controllers;

use App\Models\feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = feature::all();
        return view('panel.feature.index',compact('features'));
    }
    public function create()
    {
        return view('panel.feature.create');
    }
    public function edit(Feature $feature)
    {
        return view('panel.feature.edit',compact('feature'));
    }
    public function destroy(Feature $feature)
    {
        $feature->delete();
        return redirect()->route('feature.index')->with('warning','ویژگی با موفقیت حذف شد.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'icon' => 'required|string',
        ]);
        Feature::create([
            'title' => $request->title,
            'body' => $request->body,
            'icon' => $request->icon
        ]);
        return redirect()->route('feature.index')->with('success','ویژگی با موفقیت ایجاد شد.');
    }
    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'icon' => 'required|string'
        ]);
        $feature->update([
            'title' => $request->title,
            'body' => $request->body,
            'icon' => $request->icon,
        ]);
        return redirect()->route('feature.edit',['feature' => $feature->id])->with('success','ویژگی با موفقیت آپدیت شد.');
    }

}
