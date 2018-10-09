<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountHolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_holders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('pin', 16); // simple password - only works if their banker is logged in
            $table->string('name', 63);
            $table->date('birthdate')->nullable();
            $table->enum('sex', ['m', 'f'])->nullable();
            $table->integer('user_id')->references('id')->on('users')->nullable();
            $table->integer('bank_id')->references('id')->on('banks');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_holders');
    }
}
