<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP23 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_item_category_id')->nullable()->default(null);
            $table->foreign('ar_invoice_item_category_id')->references('id')->on('ar_invoice_item_category')->onDelete('set null');

            $table->string('product_name')->nullable()->default(null);
            $table->unsignedInteger('product_price')->nullable()->default(0);
            $table->unsignedInteger('product_price_usd')->nullable()->default(0);
            $table->unsignedInteger('product_price_sgd')->nullable()->default(0);

            $table->unsignedSmallInteger('enterprise_billing_date')->nullable()->default(1);
            $table->unsignedSmallInteger('billing_time')->nullable()->default(1);
            $table->unsignedSmallInteger('billing_cycle')->nullable()->default(1);

            $table->boolean('active')->nullable()->default(false);
            $table->boolean('qrcode')->nullable()->default(true);

            $table->unsignedBigInteger('ar_invoice_faktur_id')->nullable()->default(null);
            $table->foreign('ar_invoice_faktur_id')->references('id')->on('ar_invoice_faktur')->onDelete('set null');

            $table->string('receiver_name')->nullable()->default(null);
            $table->string('receiver_address')->nullable()->default(null);
            $table->string('receiver_phone_number')->nullable()->default(null);
            $table->string('receiver_email')->nullable()->default(null);
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
