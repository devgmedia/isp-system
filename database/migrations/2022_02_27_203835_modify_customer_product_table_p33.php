<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP33 extends Migration
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
            $table->dropForeign('customer_product_dependency_foreign');
        });

        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropColumn('site_postal_code');
            $table->dropColumn('dependency');
            $table->dropColumn('first_month_not_billed');

            $table->boolean('hybrid')->nullable()->default(false)->change();
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
