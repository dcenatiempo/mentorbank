<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function bank(Request $request) {
        if ($request->get('pin') == $request->user()->banker->pin) {
            $request->session()->forget(['portal', 'account_id']);
            return response(['sucess' => 'logging in as banker'], 200);
        }
        return response(['error' => 'wrong pin'], 400);
    }

    public function account(Request $request) {
        $pin = $request->get('pin');
        $id = $request->get('id');
        $account = $request->user()->banker->bank->accounts()->find($id);

        if (!$account) {
            return response(['error' => 'unauthorized to access this account'], 403);
        }
        $accountHolder = $account->accountHolder;

        if ($pin == $accountHolder->pin) {
            $request->session()->put('account_id', $id);
            return response(['sucess' => 'logging in as account holder'], 200);
        }
        return response(['error' => 'wrong pin'], 400);
    }
}
