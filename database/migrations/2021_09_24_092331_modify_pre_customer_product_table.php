<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class ModifyPreCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_customer_product', function ($table) {
            $table->boolean('custom_site_information')->nullable()->default(false);
            $table->string('site_name')->nullable()->default(null);
            $table->unsignedBigInteger('site_province_id')->nullable()->default(null);
            $table->unsignedBigInteger('site_district_id')->nullable()->default(null);
            $table->unsignedBigInteger('site_sub_district_id')->nullable()->default(null);
            $table->unsignedBigInteger('site_village_id')->nullable()->default(null);
            $table->string('site_address')->nullable()->default(null);
            $table->float('site_latitude', 20, 10)->nullable()->default(null);
            $table->float('site_longitude', 20, 10)->nullable()->default(null);
            $table->string('site_postal_code')->nullable()->default(null);

            $table->unsignedBigInteger('agent_id')->nullable()->default(null);
            $table->unsignedBigInteger('sales')->nullable()->default(null);

            $table->boolean('adjusted_price')->nullable()->default(false);
            $table->unsignedInteger('special_price')->nullable()->default(null);

            $table->boolean('ignore_tax')->nullable()->default(false);
            $table->boolean('ignore_prorated')->nullable()->default(false);
            $table->boolean('postpaid')->nullable()->default(false);

            $table->boolean('adjusted_bandwidth')->nullable()->default(false);
            $table->unsignedInteger('special_bandwidth')->nullable()->dafault(null);

            $table->boolean('custom_billing_information')->nullable()->default(false);
            $table->string('billing_name')->nullable()->default(null);
            $table->unsignedBigInteger('billing_province_id')->nullable()->default(null);
            $table->unsignedBigInteger('billing_district_id')->nullable()->default(null);
            $table->unsignedBigInteger('billing_sub_district_id')->nullable()->default(null);
            $table->unsignedBigInteger('billing_village_id')->nullable()->default(null);
            $table->string('billing_address')->nullable()->default(null);
            $table->float('billing_latitude', 20, 10)->nullable()->default(null);
            $table->float('billing_longitude', 20, 10)->nullable()->default(null);
            $table->string('billing_postal_code')->nullable()->default(null);

            $table->unsignedBigInteger('join_billing_id')->nullable()->default(null);
        });

        Schema::table('pre_customer_product', function ($table) {
            $table->foreign('site_province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('site_district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('site_sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('site_village_id')->references('id')->on('village')->onDelete('set null');

            $table->foreign('agent_id')->references('id')->on('agent')->onDelete('set null');
            $table->foreign('sales')->references('id')->on('employee')->onDelete('set null');

            $table->foreign('billing_province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('billing_district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('billing_sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('billing_village_id')->references('id')->on('village')->onDelete('set null');

            $table->foreign('join_billing_id')->references('id')->on('pre_customer_product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_customer_product', function ($table) {
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

            $table->dropColumn('agent_id');
            $table->dropColumn('sales');

            $table->dropColumn('adjusted_price');
            $table->dropColumn('special_price');

            $table->dropColumn('ignore_tax');
            $table->dropColumn('ignore_prorated');
            $table->dropColumn('postpaid');

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
        });
    }
}
