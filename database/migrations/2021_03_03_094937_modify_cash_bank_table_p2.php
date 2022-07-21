<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashBankTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('cash_bank', function (Blueprint $table) {
            $table->boolean('is_cash')->nullable()->default(false);
            $table->boolean('is_small_cash')->nullable()->default(false);
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
            $table->dropColumn('is_cash');
            $table->dropColumn('is_small_cash');
        });
    }
}
