<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmbarquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('embarques', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contrato_id')->unsigned();
            $table->integer('entrega');
            $table->string('nota_fiscal')->nullable();
            $table->double('quantidade')->nullable();
            $table->date('data_embarque')->nullable();
            $table->double('saldo')->nullable();
            $table->date('data_pagamento')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->foreign('contrato_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('embarques');
    }
}
