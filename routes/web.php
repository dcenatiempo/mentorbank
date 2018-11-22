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
    Route::get('/portal','ViewController@portal');
    Route::post('/portal/logout','ViewController@portal');
    Route::get('/home', 'ViewController@home');
    Route::get('/onboarding', 'ViewController@onboarding');
    Route::get('/bank', 'ViewController@bank');
    Route::get('/bank/{any}', 'ViewController@bank')->where(['any' => '.*']);
    Route::get('/account', 'ViewController@account');
    Route::get('/account/{any}', 'ViewController@account')->where(['any' => '.*']);

    Route::prefix('api')->group(function () {
        
        // loging in through portal
        Route::prefix('portal')->group(function () {
            Route::post('/bank', 'PortalController@bank');
            Route::post('/account', 'PortalController@account');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', 'UserController@index');
            Route::patch('/', 'UserController@update');
            Route::delete('/', 'UserController@delete');
        });

        Route::apiResources([
            'account-holder' => 'AccountHolderController'
        ]);

        Route::prefix('bank')->group(function () {
            Route::get(   '/', 'BankController@index');     // get a banks
            Route::post(  '/', 'BankController@store');     // create a bank
            Route::put(   '/{bank}', 'BankController@update');    // edit a bank
            Route::patch( '/{bank}', 'BankController@update');    // edit a bank
            Route::delete('/{bank}', 'BankController@destroy');   // delete a bank

            /************************************************************
            Verb	    URI	                    Action	    Route Name
            ----        ---                     ------      ----------
            GET	        /things	                index	    things.index
            POST	    /things	                store	    things.store
            GET	        /things/{id}	        show	    things.show
            PUT/PATCH   /things/{id}	        update	    things.update
            DELETE	    /things/{id}	        destroy	    things.destroy
            ***************************************************************/
            Route::apiResources([
                'category' => 'BankCategoryController',
                'transaction' => 'BankTransactionController',
                'subscribed-category' => 'BankSubscribedCategoryController',
                'notification' => 'BankNotificationController',
                'recurring-template' => 'BankRecurringTemplateController',
            ]);
            
            // Route::prefix('category')->group(function () {
            //     Route::get('/', 'BankCategoryController@index');        // get all cats for a bank
            //     Route::post('/', 'BankCategoryController@store');            // create a new bank cat
            //     // Route::patch('/{id}', 'CategoryController@update');     // edit a bank cat
            //     // Route::delete('/{id}', 'CategoryController@delete');    // delete a bank cat
            // });

            // Route::prefix('notification')->group(function () {
            //     // Route::get('/', '');         // get notifications (for a bank)
            //     // Route::put('/', '');         // add a notification to a bank
            //     // Route::patch('/{id}', '');  // edit a notification (for a bank)
            //     // Route::delete('/{id}', ''); // remove a notification (from a bank)
            // });

            // Route::prefix('recurringTemplate')->group(function () {
            //     // Route::get('/', '');         // get templates (for a bank)
            // });

            // Route::prefix('transaction')->group(function () {
            //     Route::get('/', 'BankTransactionController@index');         // get transactions (for an bank)
            // });

            // Route::prefix('subscribedCategory')->group(function () {
            //     Route::get('/', 'BankTransactionController@index');         // get transactions (for an bank)
            // });
        });

        Route::prefix('account')->group(function () {
            Route::get('/', 'AccountController@index');         // get all accounts (for a bank)
            Route::post('/', 'AccountController@store');        // create an account
            Route::get('/{id}', 'AccountController@show');      // get a single account (for a bank)
            Route::patch('/{id}', 'AccountController@update');  // edit an account
            Route::patch('/{id}', 'AccountController@update');  // edit an account 
            Route::delete('/{id}', 'AccountController@delete'); // delete an account

            Route::prefix('{id}')->group(function () {
                /************************************************************
                Verb	    URI	                    Action	    Route Name
                ----        ---                     ------      ----------
                GET	        /things	                index	    things.index
                POST	    /things	                store	    things.store
                GET	        /things/{thing}	        show	    things.show
                PUT/PATCH   /things/{thing}	        update	    things.update
                DELETE	    /things/{thing}	        destroy	    things.destroy
                ***************************************************************/
                Route::apiResources([
                    'account-holder' => 'AccountHolderController',
                    'transaction' => 'AccountTransactionController',
                    'subscribed-category' => 'AccountSubscribedCategoryController',
                    'notification' => 'AccountNotificationController',
                    'recurring-template' => 'AccountRecurringTemplateController'
                ]);
            });
        });
    });
});
