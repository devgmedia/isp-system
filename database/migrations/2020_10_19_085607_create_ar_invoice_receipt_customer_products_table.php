<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceReceiptCustomerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('ar_invoice_receipt_customer_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_receipt_customer_id')->nullable()->default(null);

            $table->unsignedBigInteger('customer_product_id')->nullable()->default(null);
            $table->string('customer_product_name')->nullable()->default(null);
            $table->double('customer_product_price')->nullable()->default(null);
            $table->boolean('customer_product_price_include_vat')->nullable()->default(null);
            $table->unsignedBigInteger('customer_product_payment_scheme_id')->nullable()->default(null);
            $table->string('customer_product_payment_scheme_name')->nullable()->default(null);
            $table->unsignedInteger('customer_product_bandwidth')->nullable()->default(null);
            $table->unsignedBigInteger('customer_product_bandwidth_unit_id')->nullable()->default(null);
            $table->string('customer_product_bandwidth_unit_name')->nullable()->default(null);

            $table->double('price');
            $table->double('discount');
            $table->double('dpp');
            $table->double('ppn');
            $table->double('total');

            $table->date('billing_start_date')->nullable()->default(null);
            $table->date('billing_end_date')->nullable()->default(null);
            $table->date('billing_date')->nullable()->default(null);

            $table->unsignedBigInteger('customer_product_bandwidth_type_id')->nullable()->default(null);
            $table->string('customer_product_bandwidth_type_name')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('ar_invoice_receipt_customer_id', 'ar_invoice_receipt_customer_product_ar_inv_rec_cus_id_foreign')->references('id')->on('ar_invoice_receipt_customer')->onDelete('set null');
            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
            $table->foreign('customer_product_payment_scheme_id', 'ar_invoice_receipt_customer_product_cus_pro_pay_sch_id_foreign')->references('id')->on('payment_scheme')->onDelete('set null');
            $table->foreign('customer_product_bandwidth_unit_id', 'ar_invoice_receipt_customer_product_cus_pro_ban_uni_id_foreign')->references('id')->on('bandwidth_unit')->onDelete('set null');
            $table->foreign('customer_product_bandwidth_type_id', 'ar_invoice_receipt_customer_product_cus_pro_ban_typ_id_foreign')->references('id')->on('bandwidth_type')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_receipt_customer_product');
    }
}
