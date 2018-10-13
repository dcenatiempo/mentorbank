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
            Route::get('/', 'BankController@index');        // get a bank
            Route::put('/', 'BankController@store');        // create a bank
            Route::patch('/', 'BankController@update');     // edit a bank
            Route::delete('/', 'BankController@delete');    // delete a bank

            Route::prefix('category')->group(function () {
                Route::get('/', 'CategoryController@index');            // get all cats for a bank
                Route::put('/', 'CategoryController@store');            // create a new bank cat
                Route::patch('/{id}', 'CategoryController@update');     // edit a bank cat
                Route::delete('/{id}', 'CategoryController@delete');    // delete a bank cat
            });

            Route::prefix('transaction')->group(function () {
                Route::get('/', '');         // get transactions (for an bank)
            });

            Route::prefix('notification')->group(function () {
                Route::get('/', '');         // get notifications (for a bank)
                Route::put('/', '');         // add a notification to a bank
                Route::patch('/{id}', '');  // edit a notification (for a bank)
                Route::delete('/{id}', ''); // remove a notification (from a bank)
            });

            Route::prefix('recurringTemplate')->group(function () {
                Route::get('/', '');         // get templates (for a bank)
            });
        });

        Route::prefix('account')->group(function () {
            Route::get('/', 'AccountController@index');         // get all accounts (for a bank)
            Route::put('/', 'AccountController@store');         // create an account
            Route::get('/{id}', 'AccountController@index');     // get a single account (for a bank)
            Route::patch('/{id}', 'AccountController@update');  // edit an account 
            Route::delete('/{id}', 'AccountController@delete'); // delete an account

            Route::prefix('{id}')->group(function () {
                Route::prefix('category')->group(function () {
                    Route::get('/', '');         // get all categories (for an account)
                    Route::get('/{id}', '');     // get a single category (for an account)
                    Route::put('/', '');         // add a category to an account (possibly create one for the bank too)
                    Route::patch('/{id}', '');  // edit a category (for an account)
                    Route::delete('/{id}', ''); // remove a category (from an account)
                });

                Route::prefix('transaction')->group(function () {
                    Route::get('/', '');         // get transactions (for an account)
                    Route::put('/', '');         // add a transaction to an account
                    Route::patch('/{id}', '');  // edit a transaction (for an account)
                    Route::delete('/{id}', ''); // remove a transaction (from an account)
                });

                Route::prefix('notification')->group(function () {
                    Route::get('/', '');         // get notifications (for an account)
                    Route::put('/', '');         // add a notification to an account
                    Route::patch('/{id}', '');  // edit a notification (for an account)
                    Route::delete('/{id}', ''); // remove a notification (from an account)
                });

                Route::prefix('recurringTemplate')->group(function () {
                    Route::get('/', '');         // get templates (for an account)
                    Route::put('/', '');         // add a template to an account
                    Route::patch('/{id}', '');  // edit a template (for an account)
                    Route::delete('/{id}', ''); // remove a template (from an account)
                });
            });
        });
    });
});
