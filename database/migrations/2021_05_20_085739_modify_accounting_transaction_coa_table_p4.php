<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAccountingTransactionCoaTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->unsignedBigInteger('coa_title_id')->nullable()->default(null);
            $table->foreign('coa_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');

            $table->unique(['transaction_id', 'coa_title_id'], 'acc_tra_coa_tra_id_coa_tit_id_unique');
        });

        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->dropUnique('acc_tra_coa_tra_id_coa_id_coa_car_id_unique');
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
            $table->dropForeign('accounting_transaction_coa_coa_title_id_foreign');
            $table->dropForeign('accounting_transaction_coa_branch_id_foreign');
        });

        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->dropColumn('coa_title_id');
            $table->dropColumn('branch_id');

            $table->unique(['transaction_id', 'coa_id', 'coa_card_id'], 'acc_tra_coa_tra_id_coa_id_coa_car_id_unique');
        });

        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->dropUnique('acc_tra_coa_tra_id_coa_tit_id_unique');
        });
    }
}
