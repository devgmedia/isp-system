<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP4 extends Migration
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
            $table->dropForeign('customer_product_customer_relation_foreign');
        });

        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropColumn('customer_relation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_relation')->nullable()->default(null);
            $table->foreign('customer_relation')->references('id')->on('employee')->onDelete('set null');
        });
    }
}
