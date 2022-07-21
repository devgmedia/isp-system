<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierInTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('cashier_in', function (Blueprint $table) {
            $table->boolean('small_cash_top_up')->nullable()->default(false);
            $table->boolean('small_cash_loan')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashier_in', function (Blueprint $table) {
            $table->dropColumn('small_cash_top_up');
            $table->dropColumn('small_cash_loan');
        });
    }
}
