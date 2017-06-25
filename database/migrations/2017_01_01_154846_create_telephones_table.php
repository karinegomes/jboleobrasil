<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelephonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telephones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ddd', 10);
            $table->string('number', 10);
            $table->string('type', 8);
            $table->integer('extension');
            $table->integer('client_id')->unsigned();
            $table->integer('carrier_id')->unsigned();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('carrier_id')->references('id')->on('carriers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('telephones');
    }
}
