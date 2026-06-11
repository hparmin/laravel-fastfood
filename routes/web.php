<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;


// app routes
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/about', function () { return view('app.about');})->name('app.about');


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

