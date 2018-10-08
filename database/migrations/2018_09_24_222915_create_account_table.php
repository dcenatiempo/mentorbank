<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->float('interest_rate', 4, 2)->default(0);
            $table->boolean('notifications')->default(true);
            $table->integer('goal_balance');
            $table->integer('low_balance_alert');
            $table->integer('view'); // 0-simple, 1-intermediate, 2-advanced
            $table->boolean('allow_negative_balance')->default(false);
            $table->integer('overdraft_fee')->default(0); //in cents
            $table->float('credit_interest_rate', 4, 2)->default(0);
            $table->integer('bank_id')->references('id')->on('banks');
            $table->integer('account_holder_id')->references('id')->on('account_holders');
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
