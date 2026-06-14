<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        $categories = category::all();
        return view('panel.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'primary_image' => 'required|image',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'images.*' => 'nullable|image',
        ]);
        // using our helper function slugify:
        $slug = $this->makeSlug($request->name);

        // main picture:
        $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
        $request->primary_image->storeAs('images/products/', $primaryImageName);

        // other pictures:
        $fileNameImages = [];
        if ($request->has('images') && $request->images != null){
            foreach ($request->images as $image){
                $fileNameImage = Carbon::now()->microsecond . '-' . $image->getClientOriginalName();
                $image->storeAs('images/products/', $fileNameImage);
            }
            array_push($fileNameImages, $fileNameImage);
        }

        product::create([
            'primary_image' => $primaryImageName,
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request->has('sale_price') ? $request->sale_price : 0,
            'date_on_sale_from' => $request->date_on_sale_from  !== null ? getMiladiDate($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? getMiladiDate($request->date_on_sale_to) : null
        ]);
        return redirect()->back()->with('success','بالاخره پست با موفقیت منتشر شد.');
    }

    public function makeSlug($sting)
    {
        $slug = slugify($sting);
        $count = product::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $result = $count ? $slug."-".$count : $slug;
        return $result;
    }


}
