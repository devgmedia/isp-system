<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerProductBillingPhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('pre_customer_product_billing_phone_number', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('name')->nullable()->default(null);
            $table->unsignedBigInteger('pre_customer_product_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['number', 'pre_customer_product_id'], 'num_pre_cus_pro_sit_pho_num_unique');
            $table->foreign('pre_customer_product_id', 'pre_cus_pro_foreign_id')->references('id')->on('pre_customer_product')->onDelete('set null');

            $table->boolean('whatsapp')->nullable()->default(false);
            $table->boolean('telegram')->nullable()->default(false);
            $table->boolean('home')->nullable()->default(false);
            $table->boolean('office')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_customer_product_billing_phone_number');
    }
}
