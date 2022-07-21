<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceItemTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->unsignedBigInteger('pr_category_id')->nullable()->default(null);
            $table->foreign('pr_category_id')->references('id')->on('ap_invoice_item_pr_category')->onDelete('set null');
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
            $table->dropForeign('ap_invoice_item_pr_category_id_foreign');
        });

        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->dropColumn('pr_category_id');
        });
    }
}
