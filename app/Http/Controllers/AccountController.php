<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Account;
use App\AccountHolder;
use App\Transaction;
use App\SubscribedCategory;
use App\Http\Resources\Account as AccountResource;
// use App\Http\Resources\AccountCollection as AccountCollectionResource;

class AccountController extends Controller
{
    function index (Request $request) {
        $accounts = $request->user()->banker->bank->accounts;
        
        return AccountResource::collection($accounts);
        // return new AccountCollectionResource($request->user()->banker->bank->accounts()->paginate(15));
    }

    function store (Request $request) {
        // TODO validate request

        $birth_date = $request->input('birthDate');
        $bank = $request->user()->banker->bank;

        // Create new accountHolder
        $accountHolder = new AccountHolder;
        $accountHolder->pin = $this->createRandomPin(4);
        $accountHolder->bank_id = $bank->id;
        $accountHolder->name = $request->input('name');
        $accountHolder->birthdate = $birth_date;
        $accountHolder->sex = $request->input('sex');
        $accountHolder->save();
        
        // Create new account
        $account = new Account;
        $account->bank_id = $bank->id;
        $account->account_holder_id = $accountHolder->id;
        $account->save();

        // Create new subscribedCategories
        $forceSubscribeCategories = $bank->getForcedSubscribeCategories();
        $subscribedCategories = [];
        foreach($forceSubscribeCategories as $category) {
            $subedCat = SubscribedCategory::create([
                'account_id' => $account->id,
                'category_id' => $category->id
            ]);
            
            $subscribedCategories[] = SubscribedCategory::find($subedCat->id);
        }


        $account = (Account::find($account->id));
        return new AccountResource($account);
    }

    function update (Request $request, $id) {
        
        $account = $this->isAuthorized($request, $id);
        
        if (!$account) {
            return response("", 403);
        }

        $account->update($request->post());

        return new AccountResource(Account::find($id));
    }

    function delete (Request $request) {
        return "TODO: delete account";
    }

    // Helper functions
    function createRandomPin($length) {
        $characters = '0123456789';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring = $randstring . $characters[rand(0, strlen($characters)-1)];
        }
        return $randstring;
    }

    function isAuthorized(Request $request, $id) {
        $user = $request->user();

        // does the account id belong to this user?
        $account = $user->banker->bank->accounts->firstWhere('id', $id);
        return $account;
    }
}
