<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceCustomerProductAdditionalTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_item_category_id')->nullable()->default(null);
            $table->foreign('ar_invoice_item_category_id', 'ar_inv_cus_pro_add_ar_inv_ite_cat_id_foreign')->references('id')->on('ar_invoice_item_category')->onDelete('set null');

            $table->float('total_usd', 15, 2)->nullable()->default(0);
            $table->float('total_sgd', 15, 2)->nullable()->default(0);
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
