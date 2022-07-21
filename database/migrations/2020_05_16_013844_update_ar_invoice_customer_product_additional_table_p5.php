<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerProductAdditionalTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_product_additional_bandwidth_type_id')->nullable()->default(null);
            $table->string('customer_product_additional_bandwidth_type_name')->nullable()->default(null);

            $table->foreign(
                'customer_product_additional_bandwidth_type_id',
                'ar_inv_cus_pro_add_cus_pro_add_ban_typ_id_foreign',
            )
                ->references('id')
                ->on('bandwidth_type')
                ->onDelete('set null');
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
            $table->dropForeign('ar_inv_cus_pro_add_cus_pro_add_ban_typ_id_foreign');
        });

        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->dropColumn([
                'customer_product_additional_bandwidth_type_id',
                'customer_product_additional_bandwidth_type_name',
            ]);
        });
    }
}
