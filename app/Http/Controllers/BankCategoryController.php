<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
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

        $response = $bank->getStandardCategories()->filter(function ($item) {
            return $item->hidden == false;
        })->values();

        return response($response);
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
        $standard = $request->input('standard');

        $category = Category::create([
            'name' => $name,
            'bank_id' => $bank->id,
            'standard' => $standard
        ]);

        return Category::find($category->id);
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
