<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductAdditionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('customer_product_additional', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sid')->unique()->nullable()->default(null);
            $table->date('registration_date');
            $table->unsignedBigInteger('customer_product_id')->nullable()->default(null);
            $table->unsignedBigInteger('product_additional_id')->nullable()->default(null);
            $table->unsignedBigInteger('media_id')->nullable()->default(null);
            $table->unsignedBigInteger('media_vendor_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
            $table->foreign('product_additional_id')->references('id')->on('product_additional')->onDelete('set null');
            $table->foreign('media_id')->references('id')->on('internet_media')->onDelete('set null');
            $table->foreign('media_vendor_id')->references('id')->on('internet_media_vendor')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_product_additional');
    }
}
