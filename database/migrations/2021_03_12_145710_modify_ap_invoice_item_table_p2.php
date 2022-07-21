<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceItemTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->foreign('ap_invoice_id')->references('id')->on('ap_invoice')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('ap_invoice_item_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->dropColumn('ap_invoice_item_ap_invoice_id_foreign');
            $table->dropColumn('ap_invoice_item_category_id_foreign');
        });
    }
}
