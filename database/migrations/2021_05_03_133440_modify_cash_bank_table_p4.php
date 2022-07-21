<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashBankTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_bank', function (Blueprint $table) {
            $table->renameColumn('is_small_cash', 'is_petty_cash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_bank', function (Blueprint $table) {
            $table->renameColumn('is_petty_cash', 'is_small_cash');
        });
    }
}
