<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->timestampsTz();
            $table->string('name', 63);
            $table->boolean('standard')->default(false); // standard for all accounts: General, Accrued Interest
            $table->boolean('archived')->default(false);
            $table->boolean('notifications')->default(true);
            $table->integer('goal_balance'); // in cents
            $table->integer('low_balance_alert'); // in cents
            $table->integer('account_id')->references('id')->on('account')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
