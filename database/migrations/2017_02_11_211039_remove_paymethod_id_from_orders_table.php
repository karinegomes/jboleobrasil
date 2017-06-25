<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePaymethodIdFromOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['paymethod_id']);
            $table->dropColumn(['paymethod_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('paymethod_id')->unsigned()->after('invoice_id')->nullable();
            $table->foreign('paymethod_id')->references('id')->on('paymethods');
            //$table->index('paymethod_id');
        });
    }
}
