<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Account;
use App\AccountHolder;

class AccountController extends Controller
{
    function index (Request $request) {
        //TODO: figure out a better way...
        $accounts = $request->user()->banker->bank->accounts;
        return $accounts->map(function ($account) {
            return collect($account)->merge(['accountHolder' => AccountHolder::find($account->id)]);
        });
    }

    function store (Request $request) {
        // TODO validate request

        $birth_date = Carbon::createMidnightDate($request->input('year'), $request->input('month'), 1);
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

        $account = (Account::find($account->id));
        $account->accountHolder = AccountHolder::find($accountHolder->id);
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
