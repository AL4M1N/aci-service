<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::namespace('App\Http\Controllers')->group(function () {
    Route::namespace('Service')->prefix('service')->group(function () {
        Route::get('/index',                    'IndexController@index');
        Route::post('/store',                   'IndexController@store');
        Route::get('/all_parts',                'IndexController@all_parts');
        Route::post('/{service}/complete',      'IndexController@complete');
    });

});


Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');
