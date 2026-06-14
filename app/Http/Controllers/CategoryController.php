<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = category::all();
        return view('panel.categories.index',compact('categories'));
    }
    public function create()
    {
        return view('panel.categories.create');
    }

    public function update(Request $request, category $category)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|int'
        ]);
        $category->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->back()->with('success','دسته بندی با موفقیت بروز رسانی شد');
    }
    public function edit(category $category)
    {
        return view('panel.categories.edit',compact('category'));
    }
    public function destroy(category $category)
    {
        $category->delete();
        return redirect()->back()->with('warning','دسته بندی با موفقیت حذف شد');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'status' => 'required|int'
        ]);
        category::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return redirect()->route('categories.index')->with('success','دسته بندی با موفقیت ایجاد شد');
    }
}
