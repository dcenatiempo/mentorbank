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
            return redirect('/bank');
        } else {
            return redirect('/onboarding');
        } 
    }

    /**
     * Show the onboarding.
     *
     * @return \Illuminate\Http\Response
     */
    public function onboarding()
    {
        $banker = $request->user()->banker;
        if ($banker) {
            return redirect('/home');
        }
        return view('onboarding', [
            'pageId' => 'onboarding'
        ]);
    }

    /**
     * Show the bank dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bank(Request $request)
    {
        $banker = $request->user()->banker;
        if (!$banker) {
            return redirect('/onboarding');
        }
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
        $banker = $request->user()->banker;
        if (!$banker) {
            return redirect('/onboarding');
        }
        return view('account', [
            'pageId' => 'account'
        ]);
    }
}
