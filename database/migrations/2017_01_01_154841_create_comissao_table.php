<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComissaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissao', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipo', ['vendedor', 'comprador']);
            $table->enum('unidade', ['porcentagem', 'fixo']);
            $table->decimal('valor');
            $table->integer('contrato_id')->unsigned();
            $table->timestamps();

            $table->foreign('contrato_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comissao');
    }
}
