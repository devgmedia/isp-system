<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerDiscountTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_discount', function (Blueprint $table) {
            $table->dropForeign('customer_discount_discount_scheme_id_foreign');
            $table->dropForeign('customer_discount_discount_type_id_foreign');
        });

        Schema::table('customer_discount', function (Blueprint $table) {
            $table->dropColumn('discount_name');
            $table->dropColumn('discount_effective_date');
            $table->dropColumn('discount_expired_date');
            $table->dropColumn('discount_maximum_use');
            $table->dropColumn('discount_maximum_use_per_product');
            $table->dropColumn('discount_maximum_use_per_product_additional');
            $table->dropColumn('discount_maximum_use_per_customer');
            $table->dropColumn('discount_maximum_use_per_invoice');
            $table->dropColumn('discount_scheme_id');
            $table->dropColumn('discount_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_discount', function (Blueprint $table) {
            $table->string('discount_name');
            $table->date('discount_effective_date')->nullable()->default(null);
            $table->date('discount_expired_date')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use_per_product')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use_per_product_additional')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use_per_customer')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use_per_invoice')->nullable()->default(null);
            $table->unsignedBigInteger('discount_scheme_id')->nullable()->default(null);
            $table->unsignedBigInteger('discount_type_id')->nullable()->default(null);

            $table->foreign('discount_scheme_id')->references('id')->on('discount_scheme')->onDelete('set null');
            $table->foreign('discount_type_id')->references('id')->on('discount_type')->onDelete('set null');
        });
    }
}
