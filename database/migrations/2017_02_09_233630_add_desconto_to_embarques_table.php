<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescontoToEmbarquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('embarques', function (Blueprint $table) {
            $table->float('desconto')->nullable()->after('quantidade');
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
            $table->dropColumn(['desconto']);
        });
    }
}
