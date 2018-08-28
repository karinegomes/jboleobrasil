<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDadosBancariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_bancarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_banco')->nullable();
            $table->string('favorecido')->nullable();
            $table->string('cpf_cnpj')->nullable();
            $table->string('agencia')->nullable();
            $table->string('conta')->nullable();
            $table->integer('motorista_id')->unsigned();
            $table->timestamps();

            $table->foreign('motorista_id')->references('id')->on('motoristas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dados_bancarios');
    }
}
