<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    function index (Request $request) {
        $user = $request->user();
        
        return new UserResource($user);
    }

    function update (Request $request) {
        return "TODO: update user";
    }

    function delete (Request $request) {
        return "TODO: delete user";
    }
}
