<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP31 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropForeign('customer_product_site_province_id_foreign');
            $table->dropForeign('customer_product_site_district_id_foreign');
            $table->dropForeign('customer_product_site_sub_district_id_foreign');
            $table->dropForeign('customer_product_site_village_id_foreign');
            $table->dropForeign('customer_product_marketing_foreign');
        });

        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropColumn('site_province_id');
            $table->dropColumn('site_district_id');
            $table->dropColumn('site_sub_district_id');
            $table->dropColumn('site_village_id');
            $table->dropColumn('site_latitude');
            $table->dropColumn('site_longitude');
            $table->dropColumn('marketing');
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
