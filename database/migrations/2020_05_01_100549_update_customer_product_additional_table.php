<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerProductAdditionalTable extends Migration
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
            $table->dropForeign('customer_product_additional_customer_product_id_foreign');
            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->dropForeign('customer_product_additional_customer_product_id_foreign');
            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
        });
    }
}
