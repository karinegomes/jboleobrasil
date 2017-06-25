<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaixasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baixas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('embarque_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->date('data_pagamento');
            $table->decimal('valor');
            $table->decimal('agrosd')->nullable();
            $table->decimal('silas')->nullable();
            $table->decimal('dayane')->nullable();
            $table->string('observacao')->nullable();
            $table->timestamps();

            $table->foreign('embarque_id')->references('id')->on('embarques');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('baixas');
    }
}
