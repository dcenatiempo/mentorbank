<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function index (Request $request) {
        return $request->user();
    }

    function update (Request $request) {
        return "TODO: update user";
    }

    function delete (Request $request) {
        return "TODO: delete user";
    }
}
