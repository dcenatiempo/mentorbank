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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'ViewController@home');
    Route::get('/onboarding', 'ViewController@onboarding');
    Route::get('/bank', 'ViewController@bank');
    Route::get('/account', 'ViewController@acount');

    Route::prefix('api')->group(function () {
        
        Route::prefix('user')->group(function () {
            Route::get('/', 'UserController@index');
            Route::patch('/', 'UserController@update');
            Route::delete('/', 'UserController@delete');
        });

        Route::prefix('bank')->group(function () {
            Route::get('/', 'BankController@index');
            Route::put('/', 'BankController@store');
            Route::patch('/', 'BankController@update');
            Route::delete('/', 'BankController@delete');
        });

        Route::prefix('account')->group(function () {
            Route::get('/', 'AccountController@index');
            Route::put('/', 'AccountController@store');
            Route::patch('/', 'AccountController@update');
            Route::delete('/', 'AccountController@delete');
        });

        Route::prefix('category')->group(function () {
            Route::get('/', 'CategoryController@index');
            Route::put('/', 'CategoryController@store');
            Route::patch('/', 'CategoryController@update');
            Route::delete('/', 'CategoryController@delete');
        });

    });
});
