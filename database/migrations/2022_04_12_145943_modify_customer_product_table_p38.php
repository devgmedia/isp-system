<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP38 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropForeign('customer_product_pre_customer_id_foreign');
        });

        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropColumn('pre_customer_id');
            $table->unsignedBigInteger('pre_customer_product_id')->nullable()->default(null);
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
        //
    }
}
