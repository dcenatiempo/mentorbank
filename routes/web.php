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

Route::get('/', function () {
    return view('welcome', ['pageId' => 'welcome']);
});

Auth::routes();

Route::get('/home', 'ViewController@home');

Route::middleware([])->group(function () {
    Route::get('/profile', 'ViewController@profile');
    Route::get('/bank', 'ViewController@bank');
    Route::get('/account', 'ViewController@acount');
});
