<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerProductSiteEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('pre_customer_product_site_email', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pre_customer_product_id')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('pre_customer_product_id')->references('id')->on('pre_customer_product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_customer_product_site_email');
    }
}
