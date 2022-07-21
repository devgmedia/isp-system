<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPerCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('pre_customer_product', function (Blueprint $table) {
            $table->dropForeign('pre_customer_product_site_province_id_foreign');
            $table->dropForeign('pre_customer_product_site_district_id_foreign');
            $table->dropForeign('pre_customer_product_site_sub_district_id_foreign');
            $table->dropForeign('pre_customer_product_site_village_id_foreign');

            $table->dropForeign('pre_customer_product_billing_province_id_foreign');
            $table->dropForeign('pre_customer_product_billing_district_id_foreign');
            $table->dropForeign('pre_customer_product_billing_sub_district_id_foreign');
            $table->dropForeign('pre_customer_product_billing_village_id_foreign');

            $table->dropForeign('pre_customer_product_join_billing_id_foreign');
        });

        Schema::table('pre_customer_product', function (Blueprint $table) {
            $table->dropColumn('custom_site_information');
            $table->dropColumn('site_name');
            $table->dropColumn('site_province_id');
            $table->dropColumn('site_district_id');
            $table->dropColumn('site_sub_district_id');
            $table->dropColumn('site_village_id');
            $table->dropColumn('site_address');
            $table->dropColumn('site_latitude');
            $table->dropColumn('site_longitude');
            $table->dropColumn('site_postal_code');
            $table->dropColumn('adjusted_price');
            $table->dropColumn('special_price');
            $table->dropColumn('ignore_tax');
            $table->dropColumn('ignore_prorated');
            $table->dropColumn('postpaid');
            $table->dropColumn('adjusted_bandwidth');
            $table->dropColumn('special_bandwidth');
            $table->dropColumn('custom_billing_information');
            $table->dropColumn('billing_name');
            $table->dropColumn('billing_province_id');
            $table->dropColumn('billing_district_id');
            $table->dropColumn('billing_sub_district_id');
            $table->dropColumn('billing_village_id');
            $table->dropColumn('billing_address');
            $table->dropColumn('billing_latitude');
            $table->dropColumn('billing_longitude');
            $table->dropColumn('billing_postal_code');
            $table->dropColumn('join_billing_id');
            $table->dropColumn('elevasi');
            $table->dropColumn('pic');
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
