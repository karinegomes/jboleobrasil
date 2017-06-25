<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 4)->unique();
            $table->string('name', 100);
            $table->string('nome_fantasia', 100);
            $table->string('email', 50)->nullable();
            $table->string('ie')->nullable();
            $table->string('cpf', 14)->nullable();
            $table->string('produtor_rural', 45)->nullable();
            $table->string('nome_contato', 100)->nullable();
            $table->string('telefone', 45)->nullable();
            $table->string('caixa_postal', 45)->nullable();
            $table->text('notes')->nullable();
            $table->string('registry', 25)->nullable();
            $table->integer('address_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('address');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companies');
    }
}
