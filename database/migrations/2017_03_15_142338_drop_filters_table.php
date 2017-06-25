<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('filters');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status', 50)->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->string('reference_code', 10)->nullable();
            $table->date('min_date')->nullable();
            $table->date('max_date')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
        });
    }
}
