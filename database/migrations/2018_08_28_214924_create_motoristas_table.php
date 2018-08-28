<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMotoristasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motoristas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cpf')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->string('placa')->nullable();
            $table->text('endereco')->nullable();
            $table->text('observacoes')->nullable();
            $table->integer('tipo_de_caminhao_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tipo_de_caminhao_id')->references('id')->on('tipos_de_caminhao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('motoristas');
    }
}
