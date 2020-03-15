<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/api/owners/ownerPassword/reset', function() {
    return view('ownerIndex');
});

// 画面更新を行った時にowners群が呼ばれるようにする
Route::prefix('/owners')->group(function(){

    Route::get('/', function() {
        return view('ownerIndex');
    });

    Route::get('/owner-login', function() {
        return view('ownerIndex');
    });

    Route::get('/owner-register', function() {
        return view('ownerIndex');
    });

    Route::get('/owner-forgot-passwords', function() {
        return view('ownerIndex');
    });

    Route::get('/setting', function() {
        return view('ownerIndex');
    });

    Route::get('/setting/workdays', function() {
        return view('ownerIndex');
    });

    Route::get('/setting/login-info', function() {
        return view('ownerIndex');
    });

    Route::get('/setting/photos', function() {
        return view('ownerIndex');
    });

    Route::get('/setting/detail', function() {
        return view('ownerIndex');
    });

    Route::get('/setting/address', function() {
        return view('ownerIndex');
    });

    Route::get('/setting/url', function() {
        return view('ownerIndex');
    });

    Route::get('/shops/{id}', function() {
        return view('ownerIndex');
    });
});

Route::get('/{any?}', function() {
    return view('index');
})->where('any', '.*');
