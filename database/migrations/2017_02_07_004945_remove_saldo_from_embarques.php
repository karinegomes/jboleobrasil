<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSaldoFromEmbarques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('embarques', function (Blueprint $table) {
            $table->dropColumn('saldo');
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
            $table->double('saldo')->nullable();
        });
    }
}
