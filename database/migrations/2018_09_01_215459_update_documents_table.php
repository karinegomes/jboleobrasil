<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
            $table->integer('entity_id')->unsigned()->after('doctype_id');
            $table->string('entity_type')->after('entity_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['entity_type', 'entity_id']);
            $table->integer('company_id')->unsigned()->after('doctype_id');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }
}
