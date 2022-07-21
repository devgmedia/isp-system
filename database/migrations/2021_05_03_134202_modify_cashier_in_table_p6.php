<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierInTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_in', function (Blueprint $table) {
            $table->renameColumn('small_cash_top_up', 'petty_cash_top_up');
            $table->renameColumn('small_cash_loan', 'petty_cash_loan');
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
            $table->renameColumn('petty_cash_top_up', 'small_cash_top_up');
            $table->renameColumn('petty_cash_loan', 'small_cash_loan');
        });
    }
}
