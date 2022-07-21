<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerProductAdditionalTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->boolean('previous_month_not_billed')->nullable()->default(null);
            $table->boolean('locked_by_bill')->nullable()->default(null);
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
            $table->dropColumn([
                'previous_month_not_billed',
                'locked_by_bill',
            ]);
        });
    }
}
