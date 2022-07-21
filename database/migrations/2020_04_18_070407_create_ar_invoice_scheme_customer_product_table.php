<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceSchemeCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_scheme_customer_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_scheme_customer_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('customer_product_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign(
                'ar_invoice_scheme_customer_id',
                'ar_invoice_scheme_customer_product_inv_sch_cus_id_foreign',
            )
                ->references('id')
                ->on('ar_invoice_scheme_customer')
                ->onDelete('set null');

            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_scheme_customer_product');
    }
}
