<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymethods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('days');
            $table->string('name', 50);
            $table->string('forma_pagamento', 100)->nullable();
            $table->string('dados_bancarios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('paymethods');
    }
}
