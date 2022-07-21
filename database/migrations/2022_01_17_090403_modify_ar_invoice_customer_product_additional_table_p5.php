<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceCustomerProductAdditionalTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('product_additional_id')->nullable()->default(null);
            $table->foreign('product_additional_id', 'ar_inv_cus_pro_add_pro_add_id_foreign')->references('id')->on('product_additional')->onDelete('set null');

            $table->string('additional_name')->nullable()->default(null);
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
