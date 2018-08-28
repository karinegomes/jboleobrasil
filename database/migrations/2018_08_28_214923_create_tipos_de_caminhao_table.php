<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiposDeCaminhaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_de_caminhao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });

        DB::table('tipos_de_caminhao')->insert([
            ['nome' => 'Truck'],
            ['nome' => 'Bitruck'],
            ['nome' => 'LS'],
            ['nome' => 'Bitrem'],
            ['nome' => 'Rodotrem'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipos_de_caminhao');
    }
}
