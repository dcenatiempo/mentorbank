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
        Schema::create('account_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('archived')->default(false);
            $table->boolean('notifications')->default(true);
            $table->integer('goal_balance')->nullable(); // in cents
            $table->integer('low_balance_alert')->default(0); // in cents
            $table->boolean('hidden')->default(false);
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
        Schema::dropIfExists('account_categories');
    }
}
