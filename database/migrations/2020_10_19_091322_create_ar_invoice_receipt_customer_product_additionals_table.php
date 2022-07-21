<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceReceiptCustomerProductAdditionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_receipt_customer_product_additional', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('ar_invoice_receipt_customer_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('ar_invoice_receipt_customer_product_id')->nullable()->default(NULL);

            $table->unsignedBigInteger('customer_product_additional_id')->nullable()->default(NULL);
            $table->string('customer_product_additional_name')->nullable()->default(NULL);
            $table->double('customer_product_additional_price')->nullable()->default(NULL);
            $table->boolean('customer_product_additional_price_include_vat')->nullable()->default(NULL);
            $table->unsignedBigInteger('customer_product_additional_payment_scheme_id')->nullable()->default(NULL);
            $table->string('customer_product_additional_payment_scheme_name')->nullable()->default(NULL);
            $table->unsignedInteger('customer_product_additional_bandwidth')->nullable()->default(NULL);
            $table->unsignedBigInteger('customer_product_additional_bandwidth_unit_id')->nullable()->default(NULL);
            $table->string('customer_product_additional_bandwidth_unit_name')->nullable()->default(NULL);

            $table->double('price');
            $table->double('discount');
            $table->double('dpp');
            $table->double('ppn');
            $table->double('total');

            $table->date('billing_start_date')->nullable()->default(NULL);
            $table->date('billing_end_date')->nullable()->default(NULL);
            $table->date('billing_date')->nullable()->default(NULL);

            $table->unsignedBigInteger('customer_product_additional_bandwidth_type_id')->nullable()->default(NULL);
            $table->string('customer_product_additional_bandwidth_type_name')->nullable()->default(NULL);

            $table->timestamps();

            $table->foreign('ar_invoice_receipt_customer_id','ar_inv_rec_cus_pro_add_ar_inv_rec_cus_id_foreign')->references('id')->on('ar_invoice_receipt_customer')->onDelete('set null');
            $table->foreign('ar_invoice_receipt_customer_product_id','ar_inv_rec_cus_pro_add_ar_inv_rec_cus_pro_id_foreign')->references('id')->on('ar_invoice_receipt_customer_product')->onDelete('set null');
           
            $table->foreign('customer_product_additional_id','ar_inv_rec_cus_pro_add_cus_pro_add_id_foreign')->references('id')->on('customer_product_additional')->onDelete('set null');            
            $table->foreign('customer_product_additional_payment_scheme_id','ar_inv_rec_cus_pro_add_cus_pro_add_pay_sch_id_foreign')->references('id')->on('payment_scheme')->onDelete('set null');
            $table->foreign('customer_product_additional_bandwidth_unit_id','ar_inv_rec_cus_pro_add_cus_pro_add_ban_uni_id_foreign')->references('id')->on('bandwidth_unit')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_receipt_customer_product_additional');
    }
}
