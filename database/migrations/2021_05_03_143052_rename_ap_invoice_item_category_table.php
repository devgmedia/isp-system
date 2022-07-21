<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameApInvoiceItemCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('ap_invoice_item_category', 'ap_invoice_item_po_category');

        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->dropForeign('ap_invoice_item_category_id_foreign');
        });

        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->renameColumn('category_id', 'po_category_id');
        });

        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->foreign('po_category_id')->references('id')->on('ap_invoice_item_po_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('ap_invoice_item_po_category', 'ap_invoice_item_category');

        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->dropForeign('ap_invoice_item_po_category_id_foreign');
        });

        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->renameColumn('po_category_id', 'category_id');
        });

        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('ap_invoice_item_category')->onDelete('set null');
        });
    }
}
