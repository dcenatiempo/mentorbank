<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

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
            $table->softDeletes();

            $table->decimal('balance', 15, 2)->default(0);
            $table->integer('monthly_transactions')->default(0); //total number of transactions
            $table->integer('total_transactions')->default(0); //total number of transactions
            $table->boolean('notifications')->default(true);
            $table->integer('goal_balance')->nullable();
            $table->integer('low_balance_alert')->nullable();
            $table->integer('view')->default(0); // 0-simple, 1-intermediate, 2-advanced
            
            // Interest
            // https://en.wikipedia.org/wiki/ISO_8601#Durations
            $table->decimal('interest_rate', 4, 2)->default(10);
            $table->enum('rate_interval', ['year', 'month', 'week', 'day'])->default('month');
            $table->string('frequency', 31)->default('P2W'); // P1W, P2W, P3W, P4W, P1M 
            $table->integer('distribution_day')->default(1); // if W then 1-7 (1 = monday), if M then 1-31
            $table->date('last_distribution')->default(Carbon::now());
            $table->date('next_distribution')->default(Carbon::now()->addWeeks(2));

            // Negative: TODO - I have no plans to implement this yet...
            $table->boolean('allow_negative_balance')->default(false);
            $table->integer('overdraft_fee')->default(0); //in cents
            $table->decimal('credit_interest_rate', 4, 2)->default(0);

            // Foreign Keys
            $table->integer('bank_id')->references('id')->on('banks');
            $table->integer('account_holder_id')->references('id')->on('account_holders');

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
