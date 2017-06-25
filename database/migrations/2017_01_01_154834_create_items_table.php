<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->text('note');
            $table->date('expiry');
            $table->decimal('amount')->default('0.00');
            $table->decimal('price')->default('0.00');
            $table->integer('package_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('measure_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('measure_id')->references('id')->on('measures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
