<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropArInvoiceReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::dropIfExists('ar_invoice_receipt_customer_product_additional');
        Schema::dropIfExists('ar_invoice_receipt_customer_product');
        Schema::dropIfExists('ar_invoice_receipt_customer');
        Schema::dropIfExists('ar_invoice_receipt');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('ar_invoice_receipt', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);

            $table->string('number');
            $table->string('name');
            $table->date('date');
            $table->date('due_date');
            $table->double('price');
            $table->double('discount');
            $table->double('dpp');
            $table->double('ppn');
            $table->double('total');
            $table->double('remaining_payment')->nullable()->default(0);
            $table->double('previous_remaining_payment')->nullable()->default(0);
            $table->double('paid_total')->nullable()->default(0);
            $table->date('payment_date')->nullable()->dafault(null);
            $table->date('billing_date')->nullable()->dafault(null);

            $table->unsignedBigInteger('payer')->nullable()->dafault(null);
            $table->string('payer_cid')->nullable()->dafault(null);
            $table->string('payer_name')->nullable()->dafault(null);
            $table->unsignedBigInteger('payer_province_id')->nullable()->default(null);
            $table->string('payer_province_name')->nullable()->default(null);
            $table->unsignedBigInteger('payer_district_id')->nullable()->default(null);
            $table->string('payer_district_name')->nullable()->default(null);
            $table->unsignedBigInteger('payer_sub_district_id')->nullable()->default(null);
            $table->string('payer_sub_district_name')->nullable()->default(null);
            $table->unsignedBigInteger('payer_village_id')->nullable()->default(null);
            $table->string('payer_village_name')->nullable()->default(null);
            $table->string('payer_address')->nullable()->default(null);
            $table->string('payer_postal_code')->nullable()->default(null);
            $table->string('payer_phone_number')->nullable()->default(null);
            $table->string('payer_fax')->nullable()->default(null);
            $table->string('payer_email')->nullable()->default(null);

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->string('brand_name')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');

            $table->foreign('payer')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('payer_province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('payer_district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('payer_sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('payer_village_id')->references('id')->on('village')->onDelete('set null');

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
        });

        Schema::create('ar_invoice_receipt_customer', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('ar_invoice_receipt_id')->nullable()->default(null);
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('ar_invoice_receipt_id')->references('id')->on('ar_invoice_receipt')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });

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

        Schema::create('ar_invoice_receipt_customer_product_additional', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('ar_invoice_receipt_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('ar_invoice_receipt_customer_product_id')->nullable()->default(null);

            $table->unsignedBigInteger('customer_product_additional_id')->nullable()->default(null);
            $table->string('customer_product_additional_name')->nullable()->default(null);
            $table->double('customer_product_additional_price')->nullable()->default(null);
            $table->boolean('customer_product_additional_price_include_vat')->nullable()->default(null);
            $table->unsignedBigInteger('customer_product_additional_payment_scheme_id')->nullable()->default(null);
            $table->string('customer_product_additional_payment_scheme_name')->nullable()->default(null);
            $table->unsignedInteger('customer_product_additional_bandwidth')->nullable()->default(null);
            $table->unsignedBigInteger('customer_product_additional_bandwidth_unit_id')->nullable()->default(null);
            $table->string('customer_product_additional_bandwidth_unit_name')->nullable()->default(null);

            $table->double('price');
            $table->double('discount');
            $table->double('dpp');
            $table->double('ppn');
            $table->double('total');

            $table->date('billing_start_date')->nullable()->default(null);
            $table->date('billing_end_date')->nullable()->default(null);
            $table->date('billing_date')->nullable()->default(null);

            $table->unsignedBigInteger('customer_product_additional_bandwidth_type_id')->nullable()->default(null);
            $table->string('customer_product_additional_bandwidth_type_name')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('ar_invoice_receipt_customer_id', 'ar_inv_rec_cus_pro_add_ar_inv_rec_cus_id_foreign')->references('id')->on('ar_invoice_receipt_customer')->onDelete('set null');
            $table->foreign('ar_invoice_receipt_customer_product_id', 'ar_inv_rec_cus_pro_add_ar_inv_rec_cus_pro_id_foreign')->references('id')->on('ar_invoice_receipt_customer_product')->onDelete('set null');

            $table->foreign('customer_product_additional_id', 'ar_inv_rec_cus_pro_add_cus_pro_add_id_foreign')->references('id')->on('customer_product_additional')->onDelete('set null');
            $table->foreign('customer_product_additional_payment_scheme_id', 'ar_inv_rec_cus_pro_add_cus_pro_add_pay_sch_id_foreign')->references('id')->on('payment_scheme')->onDelete('set null');
            $table->foreign('customer_product_additional_bandwidth_unit_id', 'ar_inv_rec_cus_pro_add_cus_pro_add_ban_uni_id_foreign')->references('id')->on('bandwidth_unit')->onDelete('set null');
        });
    }
}
