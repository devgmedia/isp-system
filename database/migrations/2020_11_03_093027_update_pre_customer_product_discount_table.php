<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdatePreCustomerProductDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('pre_customer_product_discount', function ($table) {
            $table->dropColumn('registration_date');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('total_usage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_customer_product_discount', function ($table) {
            $table->date('registration_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('total_usage');
        });
    }
}
