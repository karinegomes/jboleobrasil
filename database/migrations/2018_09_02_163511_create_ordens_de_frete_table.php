<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdensDeFreteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordens_de_frete', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cidade_origem');
            $table->string('cidade_destino');
            $table->decimal('valor_frete');
            $table->decimal('peso');
            $table->integer('measure_id')->unsigned();
            $table->decimal('adiantamento');
            $table->decimal('saldo');
            $table->date('data_carregamento');
            $table->date('previsao_descarga');
            $table->integer('motorista_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('motorista_id')->references('id')->on('motoristas');
            $table->foreign('measure_id')->references('id')->on('measures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ordens_de_frete');
    }
}
