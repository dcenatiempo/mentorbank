<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecurringTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurring_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestampsTz();
            $table->date('start_date');
            $table->string('frequency', 31); // https://en.wikipedia.org/wiki/ISO_8601#Durations
            $table->string('memo', 255);
            $table->enum('type', ['withdrawal', 'deposit', 'transfer']);
            $table->jsonb('split'); // [{category, ammount}]
            $table->integer('net_amount'); // in cents - positive=deposit/transfer, negative=withdrawal
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
        Schema::dropIfExists('recurring_templates');
    }
}
