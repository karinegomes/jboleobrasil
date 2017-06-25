<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freights', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price')->default('0.00');
            $table->decimal('weight')->default('0.00');
            $table->string('address')->nullable();
            $table->string('transportadora', 100)->nullable();
            $table->date('ship_date');
            $table->date('delivery_date');
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->integer('incoterm_id')->unsigned();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('incoterm_id')->references('id')->on('incoterms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('freights');
    }
}
