<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP43 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->string('installation_message')->nullable()->default(null);
            $table->string('installation_schedule_message')->nullable()->default(null);

            $table->unsignedBigInteger('installation_report_by')->nullable()->default(null);
            $table->foreign('installation_report_by')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
