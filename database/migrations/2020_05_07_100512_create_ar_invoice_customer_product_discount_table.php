<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceCustomerProductDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_customer_product_discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_customer_product_id')->nullable()->default(null);
            $table->unsignedBigInteger('customer_product_discount_id')->nullable()->default(null);

            $table->timestamps();
            
            $table->foreign(
                'ar_invoice_customer_product_id',
                'ar_inv_cus_pro_dis_ar_inv_cus_pro_id_foreign',
            )->references('id')->on('ar_invoice_customer_product')->onDelete('set null');

            $table->foreign(
                'customer_product_discount_id',
                'ar_inv_cus_pro_dis_cus_pro_dis_id_foreign',
            )->references('id')->on('customer_product_discount')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_customer_product_discount');
    }
}
