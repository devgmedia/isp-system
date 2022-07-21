<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreCustomerTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('pre_customer', function (Blueprint $table) {
            $table->dropForeign('pre_customer_sales_foreign');
            $table->dropForeign('pre_customer_add_product_to_customer_foreign');
        });

        Schema::table('pre_customer', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('sales');
            $table->dropColumn('prospect');
            $table->dropColumn('update_to_prospect_date');
            $table->dropColumn('add_product_to_customer');
            $table->dropColumn('reqeust_coverage_checking_at');
            $table->dropColumn('fo_coverage');
            $table->dropColumn('wireless_coverage');
            $table->dropColumn('coverage_checking_at');
            $table->dropColumn('reqeust_installation_at');
            $table->dropColumn('installation_date');

            $table->string('alias_name')->nullable()->default(null);
            $table->boolean('add_to_existing_customer')->nullable()->default(false);
            $table->unsignedBigInteger('add_to_existing_customer_id')->nullable()->default(null);
            $table->string('identity_card_file')->nullable()->default(null);
            $table->string('house_photo')->nullable()->default(null);
            $table->unsignedBigInteger('customer_category_id')->nullable()->default(null);

            $table->foreign('add_to_existing_customer_id')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('customer_category_id')->references('id')->on('customer_category')->onDelete('set null');
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
