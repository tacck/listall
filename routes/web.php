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

// API環境の場合にはこちらのルーティングを使わない
if (\Illuminate\Support\Facades\App::environment('api')) {
    return;
}

// トップページ用パス
Route::get('/', function () {
    return view('welcome');
});

// 認証用パス
Auth::routes();

// 認証済み直後のホームパス
Route::get('/home', 'HomeController@index')->name('home');

// 認証済みのパス
Route::middleware(['auth'])->group(function () {

    Route::prefix('statistics')->group(function () {
        Route::get('/', 'StatisticController@index');
//        Route::get('/monthly', 'StatisticController@monthly');
    });

    Route::prefix('atomUploading')->group(function () {
        Route::get('/', 'AtomUploadingController@index');
        Route::post('/', 'AtomUploadingController@store');
    });

    Route::resource('users', 'UserController');
});