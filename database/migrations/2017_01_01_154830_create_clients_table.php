<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('email')->nullable();
            $table->integer('ddd')->nullable();
            $table->string('number', 10)->nullable();
            $table->integer('extension')->nullable();
            $table->integer('mobile_ddd')->nullable();
            $table->string('mobile_number')->nullable();
            $table->integer('carrier_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('main')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('carrier_id')->references('id')->on('carriers');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
