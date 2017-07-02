<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_code');
            $table->string('reference_order')->nullable();
            $table->text('observation');
            $table->date('sell_date');
            $table->tinyInteger('completed')->nullable();
            $table->date('data_entrega')->nullable();
            $table->integer('client_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('freight_id')->unsigned();
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->integer('seller_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('detail_id')->unsigned();
            $table->integer('paymethod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('companies');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('freight_id')->references('id')->on('freights');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('detail_id')->references('id')->on('details');
            $table->foreign('paymethod_id')->references('id')->on('paymethods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
