<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('app.index');});
Route::get('/panel', function () { return view('panel.index');});

Route::group(['prefix'=> 'sliders'], function (){
    Route::get('/create',[]);
});
