<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_category', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('archived')->default(false);
            $table->boolean('notifications')->default(true);
            $table->integer('goal_balance'); // in cents
            $table->integer('low_balance_alert'); // in cents
            $table->integer('account_id')->references('id')->on('accounts');
            $table->integer('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_category');
    }
}
