<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDadosBancariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dados_bancarios', function (Blueprint $table) {
            $table->string('tipo_conta')->nullable()->after('cpf_cnpj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dados_bancarios', function (Blueprint $table) {
            $table->dropColumn('tipo_conta');
        });
    }
}
