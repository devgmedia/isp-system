<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAccountingTransactionCoaTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->dropForeign('accounting_transaction_coa_coa_id_foreign');
            $table->dropForeign('accounting_transaction_coa_transaction_id_foreign');
        });

        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->dropUnique('acc_tra_coa_tra_id_coa_id_eff_dat');
        });

        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->dropColumn('effective_date');
            $table->foreign('coa_id')->references('id')->on('chart_of_account')->onDelete('set null');
            $table->foreign('transaction_id')->references('id')->on('accounting_transaction')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->date('effective_date')->nullable()->default(null);
        });
    }
}
