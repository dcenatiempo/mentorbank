<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    function index (Request $request) {
        //TODO: figure out a better way...
        $categories = $request->user()->banker->bank->categories;
        $standardCategories = Category::getGlobalCategories();

        return $categories->concat($standardCategories)->all();
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
