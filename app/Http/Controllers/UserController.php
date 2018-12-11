<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Carbon\Carbon;

class UserController extends Controller
{
    function index (Request $request) {
        $user = $request->user();
        
        return new UserResource($user);
    }

    function update (Request $request) {
        $user = $request->user();
        $banker = $user->banker();

        $banker->update($request->all());

        return new UserResource($user);
    }

    function delete (Request $request) {
        return "TODO: delete user";
    }
}
