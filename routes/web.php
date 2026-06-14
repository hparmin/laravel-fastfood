<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactUsController;
use \App\Http\Controllers\FooterController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\ProductController;


// app routes
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/about-us', [AboutUsController::class,'show'])->name('app.about-us');


// panel routes:
Route::get('/panel', function () { return view('panel.index');})->name('panel.index');
// the slider:
Route::group(['prefix'=> 'sliders'], function (){
    Route::get('/create',[SlidersController::class,'create'])->name('slider.create');
    Route::post('/store',[SlidersController::class,'store'])->name('slider.store');
    Route::get('/',[SlidersController::class,'index'])->name('slider.index');
    Route::get('/{slider}/edit',[SlidersController::class,'edit'])->name('slider.edit');
    Route::put('/{slider}',[SlidersController::class,'update'])->name('slider.update');
    Route::delete('/{slider}',[SlidersController::class,'destroy'])->name('slider.destroy');
});
// the feature
Route::group(['prefix'=> 'feature'], function (){
    Route::get('/create',[FeatureController::class,'create'])->name('feature.create');
    Route::post('/store',[FeatureController::class,'store'])->name('feature.store');
    Route::get('/',[FeatureController::class,'index'])->name('feature.index');
    Route::get('/{feature}/edit',[FeatureController::class,'edit'])->name('feature.edit');
    Route::put('/{feature}',[FeatureController::class,'update'])->name('feature.update');
    Route::delete('/{feature}',[FeatureController::class,'destroy'])->name('feature.destroy');
});

// the aboutUs
Route::group(['prefix'=> 'about'], function (){
    Route::get('/',[AboutUsController::class,'index'])->name('about.index');
    Route::get('/{about}/edit',[AboutUsController::class,'edit'])->name('about.edit');
    Route::put('/{about}',[AboutUsController::class,'update'])->name('about.update');
});

// the ContactUs
Route::group(['prefix'=> 'contact_us'], function (){
    Route::post('/store',[ContactUsController::class,'store'])->name('contact.store');
    Route::get('/',[ContactUsController::class,'index'])->name('contact.index');
    Route::get('/all',[ContactUsController::class,'showall'])->name('contact.showall');
    Route::delete('/{contact_us}',[ContactUsController::class,'destroy'])->name('contact.destroy');
    Route::get('/{contact_us}/show',[ContactUsController::class,'show'])->name('contact.show');
//    Route::put('/{about}',[AboutUsController::class,'update'])->name('about.update');
});

// the footer
Route::group(['prefix'=> 'footer'], function (){
    Route::get('/settings',[FooterController::class,'index'])->name('footer.index');
    Route::get('/edit',[FooterController::class,'edit'])->name('footer.edit');
    Route::put('/{footer}/update',[FooterController::class,'update'])->name('footer.update');
});

// the categories
Route::group(['prefix'=> 'categories'], function (){
    Route::get('/',[CategoryController::class,'index'])->name('categories.index');
    Route::get('/create',[CategoryController::class,'create'])->name('categories.create');
    Route::post('/store',[CategoryController::class,'store'])->name('categories.store');
    Route::delete('/{category}/destroy',[CategoryController::class,'destroy'])->name('category.destroy');
    Route::get('/{category}/edit',[CategoryController::class,'edit'])->name('category.edit');
    Route::put('/{category}/update',[CategoryController::class,'update'])->name('category.update');
});

// the products
Route::group(['prefix'=> 'products'], function (){
    Route::get('/',[ProductController::class,'index'])->name('products.index');
    Route::get('/create',[ProductController::class,'create'])->name('products.create');
    Route::get('/{product}',[ProductController::class,'create'])->name('products.create');
    Route::post('/store',[ProductController::class,'store'])->name('products.store');
    Route::delete('/{category}/destroy',[ProductController::class,'destroy'])->name('products.destroy');
    Route::get('/{category}/edit',[ProductController::class,'edit'])->name('products.edit');
    Route::put('/{category}/update',[ProductController::class,'update'])->name('products.update');
});
