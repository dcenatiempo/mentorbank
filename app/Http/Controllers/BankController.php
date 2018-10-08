<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;
use App\Banker;

class BankController extends Controller
{
    function index (Request $request) {
        return $request->user()->banker->bank->toJson();
    }

    function create (Request $request) {
        // TODO validate request
        // TODO check to see if user already is a banker
        // TODO check to see if user already has bank

        // Create new bank
        $bank = new Bank;
        $bank->name = $request->input('name');
        $bank->invite_code = md5(uniqid(rand(), true));
        $bank->save();

        // Create new banker
        $banker = new Banker;
        $banker->user_id = $request->user()->id;
        $banker->bank_id = $bank->id;
        $banker->save();

        return $bank;
    }

    function update (Request $request) {
        return "TODO: update bank";
    }

    function delete (Request $request) {
        return "TODO: delete bank";
    }
}
