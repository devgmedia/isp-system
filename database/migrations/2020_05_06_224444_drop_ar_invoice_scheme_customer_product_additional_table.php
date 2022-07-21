<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropArInvoiceSchemeCustomerProductAdditionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ar_invoice_scheme_customer_product_additional');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('ar_invoice_scheme_customer_product_additional', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_scheme_customer_product_id')->nullable()->default(null);
            $table->unsignedBigInteger('customer_product_additional_id')->unique('ar_inv_sch_cus_pro_add_cus_pro_add_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign(
                'ar_invoice_scheme_customer_product_id',
                'ar_inv_sch_cus_pro_add_ar_inv_sch_cus_pro_id_foreign',
            )
                ->references('id')
                ->on('ar_invoice_scheme_customer_product')
                ->onDelete('set null');

            $table->foreign(
                'customer_product_additional_id',
                'ar_inv_sch_cus_pro_add_cus_pro_add_id_foreign',
            )
                ->references('id')
                ->on('customer_product_additional')
                ->onDelete('set null');
        });
    }
}
