<?php

use App\Models\Order;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderIdToPaymethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paymethods', function (Blueprint $table) {
            $table->integer('order_id')->unsigned()->nullable()->after('name');

            $table->foreign('order_id')->references('id')->on('orders');
        });

        $orders = Order::all();

        foreach ($orders as $order) {
            foreach ($order->paymethods as $paymethod) {
                $paymethod->update([
                    'order_id' => $order->id
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymethods', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });
    }
}
