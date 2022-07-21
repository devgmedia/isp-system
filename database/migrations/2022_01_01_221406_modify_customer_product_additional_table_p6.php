<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductAdditionalTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_item_category_id')->nullable()->default(null);
            $table->foreign('ar_invoice_item_category_id')->references('id')->on('ar_invoice_item_category')->onDelete('set null');

            $table->string('additional_name')->nullable()->default(null);
            $table->unsignedInteger('additional_price')->nullable()->default(0);
            $table->unsignedInteger('additional_price_usd')->nullable()->default(0);
            $table->unsignedInteger('additional_price_sgd')->nullable()->default(0);
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
