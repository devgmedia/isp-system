<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_request_category_id')->nullable()->default(null);
            $table->foreign('purchase_request_category_id')->references('id')->on('ap_invoice_purchase_request_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->dropForeign('ap_invoice_purchase_request_category_id_foreign');
        });

        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->dropColumn('purchase_request_category_id');
        });
    }
}
