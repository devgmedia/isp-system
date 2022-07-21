<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceRelationV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_detail', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_detail_customer_id_foreign');
            $table->dropColumn('customer_id');

            $table->dropForeign('ar_invoice_detail_ar_invoice_id_foreign');
            $table->dropColumn('ar_invoice_id');

            $table->unsignedBigInteger('ar_invoice_customer_id')->nullable();
            $table->foreign('ar_invoice_customer_id')->references('id')->on('ar_invoice_customer_v2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customer');

            $table->unsignedBigInteger('ar_invoice_id')->nullable();
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice_v2');

            $table->dropForeign('ar_invoice_detail_ar_invoice_customer_id_foreign');
            $table->dropColumn('ar_invoice_customer_id');
        });
    }
}
