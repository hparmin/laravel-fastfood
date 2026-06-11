<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\HomeController;


// example:
Route::get('/',[HomeController::class,'index'])->name('home');

// app routes
//Route::get('/', function () { return view('app.index');})->name('home');
Route::get('/about', function () { return view('app.about');})->name('app.about');


// pane routes:
Route::get('/panel', function () { return view('panel.index');})->name('panel.index');
Route::group(['prefix'=> 'sliders'], function (){
    Route::get('/create',[SlidersController::class,'create'])->name('slider.create');
    Route::post('/store',[SlidersController::class,'store'])->name('slider.store');
    Route::get('/',[SlidersController::class,'index'])->name('slider.index');
    Route::get('/{slider}/edit',[SlidersController::class,'edit'])->name('slider.edit');
    Route::put('/{slider}',[SlidersController::class,'update'])->name('slider.update');
    Route::delete('/{slider}',[SlidersController::class,'destroy'])->name('slider.destroy');
});
