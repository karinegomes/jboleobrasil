<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 150)->nullable();
            $table->string('number', 10)->nullable();
            $table->string('complemento', 45)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('zip_code', 8)->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->tinyInteger('main');

            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('address');
    }
}
