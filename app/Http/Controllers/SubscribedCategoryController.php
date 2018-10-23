<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubscribedCategory;
use App\Account;
use Illuminate\Http\Request;
use Route;

class SubscribedCategoryController extends Controller
{
    /**
     * Display a listing of the account category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountId = Route::current()->parameter('id');
        $categories =  Account::find($accountId)->subscribedCategories;

        $balances = SubscribedCategory::getAllCategoryBalances($accountId);

        foreach ($categories as $cat) {
            $exists = isset($balances[$cat->category_id]);
            $cat->balance = $exists ? $balances[$cat->category_id] : 0;
        }
        
        return $categories;
    }

    /**
     * Store a newly created account category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified account category.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(SubscribedCategory $category)
    {
        //
    }

    /**
     * Update the specified account category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubscribedCategory $category)
    {
        //
    }

    /**
     * Remove the specified account category from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
