<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerProductAdditionalTableP6 extends Migration
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
            $table->dropColumn([
                'locked_by_bill',
                'previous_month_not_billed',
            ]);

            $table->boolean('corrected')->nullable()->default(false);
            $table->boolean('first_month_not_billed')->nullable()->default(false);
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
            $table->boolean('locked_by_bill')->nullable()->default(false);
            $table->boolean('previous_month_not_billed')->nullable()->default(false);

            $table->dropColumn([
                'corrected',
                'first_month_not_billed',
            ]);
        });
    }
}
