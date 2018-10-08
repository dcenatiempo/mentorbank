<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
         // TODO: decide where home is
        $banker = $request->user()->banker;
        if ($banker) {
            // return 'Banker!!!';
            return redirect('/bank');
        } else {
            //return 'NO BANKER YET!!!';
            return redirect('/profile');
        } 
    }

    /**
     * Show the profile dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('profile', [
            'pageId' => 'profile'
        ]);
    }

    /**
     * Show the bank dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bank()
    {
        return view('bank', [
            'pageId' => 'bank'
        ]);
    }

    /**
     * Show the account dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        return view('account', [
            'pageId' => 'account'
        ]);
    }
}
