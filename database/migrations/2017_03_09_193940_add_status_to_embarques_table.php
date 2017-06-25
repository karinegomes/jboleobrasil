<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToEmbarquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('embarques', function (Blueprint $table) {
            $table->enum('status', ['pago', 'nao_pago'])->default('nao_pago')->after('observacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('embarques', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
