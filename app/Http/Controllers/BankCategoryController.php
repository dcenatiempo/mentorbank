<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubscribedCategory;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        $forceSubscribe = $request->input('force_subscribe');
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
                SubscribedCategory::create([
                    'account_id' => $id,
                    'category_id' => $category->id
                ]);
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
        $name = $request->input('name');
        $forceSubscribe = $request->input('force_subscribe');
        // $subscribed = collect($request->input('subscribed'));

        $category->update([
            'name' => $name,
            'force_subscribe' => $forceSubscribe
        ]);

        // update/delete subscribed categories
        $oldSubscribed = $category->subscribedCategories->pluck('account_id');
        $newSubscribed = !$forceSubscribe
            ? collect($request->input('subscribed'))
            : $request->user()->banker->bank->accounts->pluck('id');

        $toDelete = $oldSubscribed->diff($newSubscribed);
        $toAdd = $newSubscribed->diff($oldSubscribed);

        if ($toAdd) {
            foreach($toAdd as $id) {
                SubscribedCategory::create([
                    'account_id' => $id,
                    'category_id' => $category->id
                ]);
            }
        }

        if ($toDelete) {
            $subedCats = SubscribedCategory::where('category_id', $category->id)->whereIn('account_id', $toDelete)->get();
            
            // This will trigger the deleting boot method on each subscribed category
            // The delete boot method will transfer the balance before deleting
            foreach ($subedCats as $cat) {
                $cat->delete();
            }
        }

        return new CategoryResource(Category::find($category->id));
    }

    /**
     * Remove the specified bank category from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Check to see if the category has any transactions associated with it
        $isInUse = $category->isInUse();

        if ($isInUse) {
            $category->delete();
        } else {
            $category->forceDelete();
        }
        
        // update all user subscribe categories
        $subedCats = $category->subscribedCategories();
        $subedCatIds = $subedCats->get()->pluck('id');

        // This will trigger the deleting boot method on each subscribed category
        // The delete boot method will transfer the balance before deleting
        foreach ($subedCats->get() as $cat) {
            $cat->delete();
        }

        return response([
            'subCatsDeleted' => $subedCatIds,

            // the crm will refetch transactions if this is true
            'refetchTransactions' => $isInUse
         ]);
    }
}
