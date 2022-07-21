<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP11 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->string('site_name')->nullable()->default(null);
            $table->string('site_email')->nullable()->default(null);
            $table->string('site_phone_number')->nullable()->default(null);
            $table->string('site_postal_code')->nullable()->default(null);
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(null);

            $table->foreign('pre_customer_id')->references('id')->on('pre_customer')->onDelete('set null');
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
            $table->dropColumn('site_name');
            $table->dropColumn('site_email');
            $table->dropColumn('site_phone_number');
            $table->dropColumn('site_postal_code');
            $table->dropColumn('pre_customer_id');
        });
    }
}
