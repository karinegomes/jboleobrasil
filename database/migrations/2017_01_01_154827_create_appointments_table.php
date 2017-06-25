<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->date('date');
            $table->time('time');
            $table->integer('user_id')->unsigned();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('interaction_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->default(1);
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('interaction_id')->references('id')->on('interactions');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('appointments');
    }
}
