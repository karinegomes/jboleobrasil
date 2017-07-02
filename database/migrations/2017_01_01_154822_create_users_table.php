<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password', 60);
            $table->string('phone', 15)->nullable();
            $table->integer('phone_ddd')->nullable();
            $table->integer('mobile_ddd')->nullable();
            $table->string('mobile_phone', 15)->nullable();
            $table->string('skype', 32)->nullable();
            $table->binary('signature')->nullable();
            $table->tinyInteger('is_admin')->default(0);
            $table->string('remember_token', 100)->nullable();
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
        Schema::drop('users');
    }
}
