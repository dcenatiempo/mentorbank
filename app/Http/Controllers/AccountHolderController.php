<?php

namespace App\Http\Controllers;

use App\AccountHolder;
use Illuminate\Http\Request;
use App\Http\Resources\AccountHolder as AccountHolderResource;

class AccountHolderController extends Controller
{
    /**
     * Display a listing of the account holder.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created account holder in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified account holder.
     *
     * @param  \App\AccountHolder  $accountHolder
     * @return \Illuminate\Http\Response
     */
    public function show(AccountHolder $accountHolder)
    {
        //
    }

    /**
     * Update the specified account holder in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccountHolder  $accountHolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountHolder $accountHolder)
    {
        // dd($request->all());
        $accountHolder->update($request->all());

        return new AccountHolderResource($accountHolder);
    }

    /**
     * Remove the specified account holder from storage.
     *
     * @param  \App\AccountHolder  $accountHolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountHolder $accountHolder)
    {
        //
    }
}
