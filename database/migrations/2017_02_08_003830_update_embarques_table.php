<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmbarquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('embarques', function (Blueprint $table) {
            $table->string('nota_fiscal')->nullable(false)->change();
            $table->float('quantidade')->nullable(false)->change();
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
            $table->string('nota_fiscal')->nullable()->change();
            $table->float('quantidade')->nullable()->change();
        });
    }
}
