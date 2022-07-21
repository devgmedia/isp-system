<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerProductTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
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
        Schema::table('customer_product', function (Blueprint $table) {
            $table->boolean('locked_by_bill')->nullable()->default(false);
            $table->boolean('previous_month_not_billed')->nullable()->default(false);

            $table->dropColumn([
                'corrected',
                'first_month_not_billed',
            ]);
        });
    }
}