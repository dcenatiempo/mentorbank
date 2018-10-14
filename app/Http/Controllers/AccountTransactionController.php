<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Route;

class AccountTransactionController extends Controller
{
    /**
     * Display a listing of transactions for an account.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $bank = $request->user()->banker->bank;
        $accountId = Route::current()->parameter('id');
        return Account::find($accountId)->transactions;
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: Validate
        $memo = $request->input('memo');
        $type = $request->input('type');
        $netAmount = $request->input('amount');
        $accountId = Route::current()->parameter('id');
        $split = json_encode($request->input('split'));

        $transaction = Transaction::create([
            'memo' => $memo,
            'type' => $type,
            'net_amount' => $netAmount,
            'split' => $split,
            'account_id' => $accountId
        ]);
        
        return $transaction;
    }

    /**
     * Display the specified transaction.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {

    }

    /**
     * Update the specified transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified transaction from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}