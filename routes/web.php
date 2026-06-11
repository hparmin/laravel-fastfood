<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlidersController;

Route::get('/', function () { return view('app.index');})->name('home');
Route::get('/panel', function () { return view('panel.index');})->name('panel.index');

Route::group(['prefix'=> 'sliders'], function (){
    Route::get('/create',[SlidersController::class,'create'])->name('slider.create');
    Route::post('/store',[SlidersController::class,'store'])->name('slider.store');
    Route::get('/',[SlidersController::class,'index'])->name('slider.index');
    Route::get('/{slider}/edit',[SlidersController::class,'edit'])->name('slider.edit');
    Route::put('/{slider}',[SlidersController::class,'update'])->name('slider.update');
    Route::delete('/{slider}',[SlidersController::class,'destroy'])->name('slider.destroy');
});
