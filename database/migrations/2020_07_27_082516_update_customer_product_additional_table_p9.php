<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerProductAdditionalTableP9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->string('sid_mapping')->nullable()->default(null);
            $table->date('service_date')->nullable()->default(null);
            $table->date('billing_date')->nullable()->default(null);
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
            $table->dropColumn('sid_mapping');
            $table->dropColumn('service_date');
            $table->dropColumn('billing_date');
        });
    }
}
