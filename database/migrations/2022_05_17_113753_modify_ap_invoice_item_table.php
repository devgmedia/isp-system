<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_customer_product_id')->nullable()->default(null);
            $table->foreign(
                'ar_invoice_customer_product_id',
                'ap_inv_ite_ar_inv_cus_pro_id_foreign'
            )
                ->references('id')
                ->on('ar_invoice_customer_product')
                ->onDelete('set null');

            $table->unsignedBigInteger('ar_invoice_customer_product_additional_id')->nullable()->default(null);
            $table->foreign(
                'ar_invoice_customer_product_additional_id',
                'ap_inv_ite_ar_inv_cus_pro_add_id_foreign'
            )
                ->references('id')
                ->on('ar_invoice_customer_product_additional')
                ->onDelete('set null');

            $table->unsignedBigInteger('ar_invoice_customer_product_discount_id')->nullable()->default(null);
            $table->foreign(
                'ar_invoice_customer_product_discount_id',
                'ap_inv_ite_ar_inv_cus_pro_dis_id_foreign'
            )
                ->references('id')
                ->on('ar_invoice_customer_product_discount')
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
        //
    }
}
