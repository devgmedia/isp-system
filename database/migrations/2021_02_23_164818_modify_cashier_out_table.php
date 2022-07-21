<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropForeign('cashier_out_bank_id_foreign');
            $table->dropForeign('cashier_out_cash_id_foreign');
        });

        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropColumn('bank_id');
            $table->dropColumn('cash_id');
        });

        Schema::table('cashier_out', function (Blueprint $table) {
            $table->unsignedBigInteger('cash_bank_id')->nullable()->default(null);
            $table->foreign('cash_bank_id')->references('id')->on('cash_bank')->onDelete('set null');
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
