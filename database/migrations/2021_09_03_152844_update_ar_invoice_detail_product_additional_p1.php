<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceDetailProductAdditionalP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_detail_product_additional', function (Blueprint $table) {
            $table->string('custom_additional')->nullable();
            $table->unsignedBigInteger('product_additional_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_detail_product_additional', function (Blueprint $table) {
            $table->dropColumn('custom_additional');
        });
    }
}
