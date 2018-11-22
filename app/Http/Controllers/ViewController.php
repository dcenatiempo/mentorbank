<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        }
        if ($request->session()->exists('portal')) {
            if ($request->session()->exists('account_id')) {
                return redirect('/account');
            }
            return redirect('/portal');
        }
        return redirect('/bank');
    }

    public function portal(Request $request)
    {
        // if ($this->shouldOnboard($request->user())) {
        //     return redirect('/onboarding');
        // } else {
            $request->session()->put('portal', true);
            $request->session()->put('account_id', null);
            return view('portal', [
                'pageId' => 'portal'
            ]);
        // }
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
        if ($request->session()->exists('portal')) {
            return redirect('/portal');
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
        if ($request->session()->exists('portal')) {
            return redirect('/portal');
        }
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
        if (!$request->session()->exists('portal')) {
            return redirect('/home');
        } else {
            if (!$request->session()->has('account_id')) {
                return redirect('/portal');
            }
            
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
