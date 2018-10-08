<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    function index (Request $request) {
        return $request->user()->banker->bank->accounts;
    }

    function create (Request $request) {
        return "TODO: create account";
    }

    function update (Request $request) {
        return "TODO: update account";
    }

    function delete (Request $request) {
        return "TODO: delete account";
    }
}
