<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactUsController;


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
    Route::get('/{contact}/show',[ContactUsController::class,'show'])->name('contact.show');
    Route::delete('/{contact_us}',[ContactUsController::class,'destroy'])->name('contact.destroy');
//    Route::put('/{about}',[AboutUsController::class,'update'])->name('about.update');
});

