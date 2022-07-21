<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_log', function (Blueprint $table) {
            $table->dropForeign('customer_change_log_customer_id_foreign');
            $table->dropForeign('customer_change_log_employee_id_foreign');
        });

        Schema::table('customer_log', function (Blueprint $table) {
            $table->renameColumn('employee_id', 'caused_by');
        });

        Schema::table('customer_log', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('caused_by')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_log', function (Blueprint $table) {
            $table->dropForeign('customer_log_customer_id_foreign');
            $table->dropForeign('customer_log_caused_by_foreign');
        });

        Schema::table('customer_log', function (Blueprint $table) {
            $table->renameColumn('caused_by', 'employee_id');
        });

        Schema::table('customer_log', function (Blueprint $table) {
            $table->foreign('customer_id', 'customer_change_log_customer_id_foreign')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('employee_id', 'customer_change_log_employee_id_foreign')->references('id')->on('employee')->onDelete('set null');
        });
    }
}
