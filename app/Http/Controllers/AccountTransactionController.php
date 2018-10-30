<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Transaction as TransactionResource;
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
        $accountId = Route::current()->parameter('id');

        $transactions = Account::find($accountId)->transactions;
        
        return TransactionResource::collection($transactions);
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
        $netAmount = $request->input('net_amount');
        $accountId = Route::current()->parameter('id');
        $date = $request->input('date');
        $split = json_encode($request->input('split'));

        $transaction = Transaction::create([
            'memo' => $memo,
            'type' => $type,
            'net_amount' => $netAmount,
            'split' => $split,
            'account_id' => $accountId,
            'date' => $date
        ]);

        $transaction = Transaction::find($transaction->id);
        
        $transaction->updateBalances();
        
        return new TransactionResource($transaction);
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
