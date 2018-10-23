<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Account;
use App\AccountHolder;
use App\Transaction;
use App\SubscribedCategory;

class AccountController extends Controller
{
    function index (Request $request) {
        $accounts = $request->user()->banker->bank->accounts;
        return $accounts->map(function ($account) {
            $accountHolder = ['accountHolder' => AccountHolder::find($account->id)];
            $account->transactions;
            $balance = ['balance' => $account->getBalance()];
            $account->subscribedCategories;
            return collect($account)->merge($accountHolder)->merge($balance);
        });
    }

    function store (Request $request) {
        // TODO validate request

        $birth_date = $request->input('birthDate');
        $bank = $request->user()->banker->bank;
        $standardBankCategories = $bank->getAllCategories();

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
        $subscribedCategories = [];
        foreach($standardBankCategories as $category) {
            $ac = SubscribedCategory::create([
                'account_id' => $account->id,
                'category_id' => $category->id
            ]);
            
            $subscribedCategories[] = SubscribedCategory::find($ac->id);
        }


        $account = (Account::find($account->id));
        $account->accountHolder = AccountHolder::find($accountHolder->id);
        $account->subscribed_categories = $subscribedCategories;
        $account->balance = $account->getBalance();
        return $account;
    }

    function update (Request $request) {
        return "TODO: update account";
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
}
