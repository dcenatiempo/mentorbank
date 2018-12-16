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
        if ($this->shouldDowngrade($request->user())) {
            return redirect('/subscription');
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
        if ($this->shouldOnboard($request->user())) {
            return redirect('/onboarding');
        }
        if ($this->shouldDowngrade($request->user())) {
            return redirect('/subscription');
        }
        $request->session()->put('portal', true);
        $request->session()->put('account_id', null);
        return view('portal', [
            'pageId' => 'portal'
        ]);
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
        if ($this->shouldDowngrade($request->user())) {
            return redirect('/subscription');
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
        if ($this->shouldDowngrade($request->user())) {
            return redirect('/subscription');
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
        if ($this->shouldDowngrade($request->user())) {
            return redirect('/subscription');
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

    public function subscription(Request $request)
    {
        if ($this->shouldOnboard($request->user())) {
            return redirect('/onboarding');
        }
        return view('subscription', [
            'pageId' => 'subscription',
            'downgrade' => $this->shouldDowngrade($request->user()) ? 'true' : 'false'
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

    private function shouldDowngrade($user) {
        $banker = $user->banker;
        if (!$banker) {
            return false;
        }
        $bank = $banker->bank;
        if (!$bank) {
            return false;
        }
        
        return $bank->shouldDowngrade();
    }
}
