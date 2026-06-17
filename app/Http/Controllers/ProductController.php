<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = product::latest('created_at')->paginate(5);
        return view('panel.products.index', compact('products'));
    }

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

        DB::beginTransaction();

        // main picture:
        $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();

        $product = product::create([
            'primary_image' => $primaryImageName,
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request->sale_price !== null ? $request->sale_price : 0,
            'date_on_sale_from' => $request->date_on_sale_from !== null ? getMiladiDate($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? getMiladiDate($request->date_on_sale_to) : null
        ]);

        // ذخیره تصویر را بعد از ایجاد رکورد انجام میدهیم که اگر به هر دلیلی رکورد ایجاد نشد تصویر هم ذخیره نشود
        $request->primary_image->storeAs('images/products/', $primaryImageName);

        // other pictures:
        $fileNameImages = [];
        if ($request->has('images') && $request->images !== null) {
            foreach ($request->images as $image) {
                $fileNameImage = $product->id . '-' . Carbon::now()->microsecond . '-' . $image->getClientOriginalName();
                $image->storeAs('images/products/', $fileNameImage);
                array_push($fileNameImages, $fileNameImage);
            }
        }
        if ($request->has('images') && $request->images !== null) {
            foreach ($fileNameImages as $fileNameImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage,
                ]);
            }
        }

        DB::commit();

        return redirect()->back()->with('success', 'بالاخره پست با موفقیت منتشر شد.');
    }

    public function update(Request $request, product $product){
        $request->validate([
//            'primary_image' => 'required|image',
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
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request->sale_price !== null ? $request->sale_price : 0,
            'date_on_sale_from' => $request->date_on_sale_from !== null ? getMiladiDate($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? getMiladiDate($request->date_on_sale_to) : null
        ]);
        return redirect()->back()->with('success','محصول با موفقیت یروزرسانی شد.');
    }

    public function show(product $product)
    {
        return view('panel.products.show', compact('product'));
    }

    public function destroy(product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('warning', 'محصول به سلط زباله منتقل شد.');
    }

    public function trash()
    {
        $trashed_products = Product::onlyTrashed()->latest('deleted_at')->paginate(10);
        return view('panel.products.trashed', compact('trashed_products'));
    }
    public function edit(product $product)
    {
        $categories = category::all();
        return view('panel.products.edit', compact('product','categories'));
    }
    public function recovery($product_id)
    {
        $product = product::withTrashed()->find($product_id);
        $product->restore();
        return redirect()->route('products.trash')->with('success', 'محصول یازیابی شد.');
    }
    public function hard_delete($product_id)
    {
        $product = product::withTrashed()->find($product_id);

        foreach ($product->images as $image) {
            Storage::delete('/images/products/' . $image->image);
        }
        Storage::delete('/images/products/' . $product->primary_image);

        $product->forceDelete();
        return redirect()->route('products.trash')->with('warning', 'محصول به طور کامل حذف شد.');
    }
    public function makeSlug($string)
    {
        $slug = slugify($string);

        $slugs = Product::withTrashed()
            ->where('slug', $slug)
            ->orWhere('slug', 'LIKE', $slug . '-%')
            ->pluck('slug')
            ->toArray();

        if (!in_array($slug, $slugs)) {
            return $slug;
        }

        $max = 0;

        foreach ($slugs as $existingSlug) {
            if (preg_match('/^' . preg_quote($slug, '/') . '-([0-9]+)$/', $existingSlug, $matches)) {
                $number = (int) $matches[1];

                if ($number > $max) {
                    $max = $number;
                }
            }
        }
        return $slug . '-' . ($max + 1);
    }

    // فانکشن دارای مشکل:
    // مشکلی اول: اگر محصولی سافت دلیت شده باشد اسلاگ تکراری خواهد شد
    // مشکل دوم: اگر سه محصول با نام تکراری منتشر شود و محصولی به غیر از آخری حذف کامل شود، باز هم اسلاگ با آخری تکراری خواهد شد.
//    public function makeSlug($sting)
//    {
//        $slug = slugify($sting);
//        $count = product::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
//        $result = $count ? $slug . "-" . $count : $slug;
//        return $result;
//    }

}
