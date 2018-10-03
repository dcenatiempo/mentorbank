<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        // TODO: decide where to redirect to
        return redirect('/profile');
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
