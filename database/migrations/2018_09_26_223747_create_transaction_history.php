<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('month'); // last day of the month
            $table->integer('ending_balance');
            $table->integer('interest_earned');
            $table->jsonb('sumary'); //
            $table->jsonb('transactions'); // json obj of all transactions for the month
            $table->integer('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_histories');
    }
}
