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
        if ($this->shouldOnboard($request->user())) {
            return redirect('/onboarding');
        } else {
            return redirect('/bank');
        } 
    }

    /**
     * Show the onboarding.
     *
     * @return \Illuminate\Http\Response
     */
    public function onboarding(Request $request)
    {
        if ($this->shouldOnboard($request->user())) {
            return view('onboarding', [
                'pageId' => 'onboarding'
            ]);
        }
        return redirect('/home');
        
    }

    /**
     * Show the bank dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bank(Request $request)
    {
        if ($this->shouldOnboard($request->user())) {
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
    public function account(Request $request)
    {
        if ($this->shouldOnboard($request->user())) {
            return redirect('/onboarding');
        }
        return view('account', [
            'pageId' => 'account'
        ]);
    }

    private function shouldOnboard($user) {
        $onboarding = true;
        if (!$user->banker) {
            return $onboarding;
        } else if (!$user->banker->bank) {
            return $onboarding;
        } else if ($user->banker->bank->accounts->isEmpty()) {
            return $onboarding;
        } else {
            $onboarding = false;
            return $onboarding;
        }
    }
}
