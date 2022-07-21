<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerProductTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropColumn('service_date');
            $table->dropColumn('billing_date');
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
            $table->date('service_date')->nullable()->default(null);
            $table->date('billing_date')->nullable()->default(null);
        });
    }
}
