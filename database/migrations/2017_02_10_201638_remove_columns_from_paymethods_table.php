<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnsFromPaymethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paymethods', function (Blueprint $table) {
            $table->dropColumn(['forma_pagamento', 'dados_bancarios']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymethods', function (Blueprint $table) {
            $table->string('forma_pagamento', 100)->nullable()->after('name');
            $table->string('dados_bancarios')->nullable()->after('forma_pagamento');
        });
    }
}
