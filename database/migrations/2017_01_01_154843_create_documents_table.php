<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('filename', 150);
            $table->string('mimetype', 100);
            $table->integer('doctype_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->timestamps();

            $table->foreign('doctype_id')->references('id')->on('doctypes');
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
        Schema::drop('documents');
    }
}
