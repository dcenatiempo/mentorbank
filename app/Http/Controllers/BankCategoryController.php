<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubscribedCategory;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
// use Illuminate\Support\Facades\Log;

class BankCategoryController extends Controller
{
    /**
     * Display a listing of the bank category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bank = $request->user()->banker->bank;

        $visibleCategories = $bank->getAllVisibleCategories();

        return CategoryResource::collection($visibleCategories);
    }

    /**
     * Store a newly created bank category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bank = $request->user()->banker->bank;
        $name = $request->input('name');
        $forceSubscribe = $request->input('forceSubscribe');
        $subscribed = !$forceSubscribe
            ? $request->input('subscribed')
            : $bank->accounts->pluck('id');

        $category = Category::create([
            'name' => $name,
            'bank_id' => $bank->id,
            'force_subscribe' => $forceSubscribe
        ]);

        // Create SubscribedCategory for users, if any
        if ($subscribed) {
            foreach($subscribed as $id) {
                $ac = SubscribedCategory::create([
                    'account_id' => $id,
                    'category_id' => $category->id
                ]);
                
                $subscribedCategories[] = SubscribedCategory::find($ac->id);
            }
        }

        return new CategoryResource(Category::find($category->id));
    }

    /**
     * Display the specified bank category.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified bank category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified bank category from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
