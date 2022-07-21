<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerProductAdditionalTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->dropForeign('ar_inv_cus_pro_add_ar_inv_cus_pro_id_foreign');
        });

        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->foreign('ar_invoice_customer_product_id', 'ar_inv_cus_pro_add_ar_inv_cus_pro_id_foreign')
                ->references('id')
                ->on('ar_invoice_customer_product')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->dropForeign('ar_inv_cus_pro_add_ar_inv_cus_pro_id_foreign');
        });

        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->foreign('ar_invoice_customer_product_id', 'ar_inv_cus_pro_add_ar_inv_cus_pro_id_foreign')
                ->references('id')
                ->on('ar_invoice_customer_product')
                ->onDelete('set null');
        });
    }
}
