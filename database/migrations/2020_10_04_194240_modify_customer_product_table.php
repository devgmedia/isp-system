<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->unsignedBigInteger('site_province_id')->nullable()->default(null);
            $table->foreign('site_province_id')->references('id')->on('province')->onDelete('set null');

            $table->unsignedBigInteger('site_district_id')->nullable()->default(null);
            $table->foreign('site_district_id')->references('id')->on('district')->onDelete('set null');

            $table->unsignedBigInteger('site_sub_district_id')->nullable()->default(null);
            $table->foreign('site_sub_district_id')->references('id')->on('sub_district')->onDelete('set null');

            $table->unsignedBigInteger('site_village_id')->nullable()->default(null);
            $table->foreign('site_village_id')->references('id')->on('village')->onDelete('set null');

            $table->string('site_address')->nullable()->default(null);
            $table->float('site_latitude', 20, 10)->nullable()->default(null);
            $table->float('site_longitude', 20, 10)->nullable()->default(null);

            $table->unsignedBigInteger('agent_id')->nullable()->default(null);
            $table->foreign('agent_id')->references('id')->on('agent')->onDelete('set null');

            $table->unsignedBigInteger('sales')->nullable()->default(null);
            $table->foreign('sales')->references('id')->on('employee')->onDelete('set null');

            $table->unsignedBigInteger('customer_relation')->nullable()->default(null);
            $table->foreign('customer_relation')->references('id')->on('employee')->onDelete('set null');
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
            $table->dromForeign('customer_product_site_province_id_foreign');
            $table->dromForeign('customer_product_site_district_id_foreign');
            $table->dromForeign('customer_product_site_sub_district_id_foreign');
            $table->dromForeign('customer_product_site_village_id_foreign');
            $table->dromForeign('customer_product_agent_id_foreign');
            $table->dropForeign('customer_sales_foreign');
            $table->dropForeign('customer_customer_relation_foreign');
        });

        Schema::table('customer_product', function (Blueprint $table) {
            $table->dromColumn('site_province_id');
            $table->dromColumn('site_district_id');
            $table->dromColumn('site_sub_district_id');
            $table->dromColumn('site_village_id');
            $table->dromColumn('site_address');
            $table->dromColumn('site_latitude');
            $table->dromColumn('site_longitude');
            $table->dromColumn('agent_id');
            $table->dropColumn('sales');
            $table->dropColumn('customer_relation');
        });
    }
}
