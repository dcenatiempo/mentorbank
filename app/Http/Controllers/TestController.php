<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    function test (Request $request) {
        $user = $request->user();
        $res = null;
        if ($user->banker()->first()) {
            $res = ['type' => 'banker',]; // banker, account_hoder, none
        } else {
            $res = ['type' => 'none']; // banker, account_hoder, none
        }
        return response()->json($res);
    }

    function thing () {
        return 'lasagna';
    }
}
