<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descontos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('embarque_id')->unsigned();
            $table->enum('tipo', ['peso', 'valor']);
            $table->double('valor');
            $table->timestamps();

            $table->foreign('embarque_id')->references('id')->on('embarques');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('descontos');
    }
}
