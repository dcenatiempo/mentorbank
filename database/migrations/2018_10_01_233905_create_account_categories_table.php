<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestampsTz();
            $table->boolean('archived')->default(false);
            $table->boolean('notifications')->default(true);
            $table->integer('goal_balance'); // in cents
            $table->integer('low_balance_alert'); // in cents
            $table->integer('account_id')->references('id')->on('account');
            $table->integer('category_id')->references('id')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_categories');
    }
}
