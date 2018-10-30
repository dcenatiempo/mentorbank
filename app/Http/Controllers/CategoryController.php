<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
{
    function index (Request $request) {
        $bankCategories = $request->user()->banker->bank->categories;
        $globalCategories = Category::getGlobalCategories();

        $allBankCats = $bankaCtegories->concat($globalCategories)->all();

        return new CategoryResource($allBankCats);
    }

    function store (Request $request) {
        // TODO validate request

        $name = $request->input('name');
        $bank = $request->user()->banker->bank;

        $category = new Category;
        $category->name = $name;
        $category->bank_id = $bank->id;
        
        $category->save();

        $category = (Category::find($category->id));
        return $category;
    }

    function update (Request $request) {
        return "TODO: update category";
    }

    function delete (Request $request) {
        return "TODO: delete category";
    }

    // Helper functions

}
