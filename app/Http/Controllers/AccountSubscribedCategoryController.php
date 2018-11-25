<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubscribedCategory;
use App\Account;
use App\Http\Resources\SubscribedCategory as SubscribedCategoryResource;
use Illuminate\Http\Request;
use Route;

class AccountSubscribedCategoryController extends Controller
{
    /**
     * Display a listing of the account category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountId = Route::current()->parameter('id');

        $subedCats = Account::find($accountId)->subscribedCategories;

        return SubscribedCategoryResource::collection($subedCats);
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
     * @param  \App\SubscribedCategory  $subscribedCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubscribedCategory $subscribedCategory)
    {
        //
    }


    public function update(Request $request, $accountId, SubscribedCategory $subscribedCategory)
    {
        $subscribedCategory->update($request->all());

        return new SubscribedCategoryResource($subscribedCategory);
    }

    /**
     * Remove the specified account category from storage.
     *
     * @param  \App\SubscribedCategory  $subscribedCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubscribedsCategory $subscribedCategory)
    {
        //
    }
}
