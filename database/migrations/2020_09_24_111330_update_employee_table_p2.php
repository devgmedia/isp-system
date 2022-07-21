<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmployeeTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropForeign(['regional_id']);
            $table->dropForeign(['company_id']);

            $table->foreign('regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropForeign(['regional_id']);
            $table->dropForeign(['company_id']);

            $table->foreign('regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('set null');
        });
    }
}
