<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyChartOfAccountTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('chart_of_account', function (Blueprint $table) {
            $table->dropUnique('cha_of_acc_cod_nam_app_sta_dat_app_end_dat_bra_id_unique');
            $table->dropForeign('chart_of_account_branch_id_foreign');
            $table->dropForeign('chart_of_account_transaction_id_foreign');
        });

        Schema::table('chart_of_account', function (Blueprint $table) {
            $table->dropColumn('branch_id');
            $table->dropColumn('transaction_id');
            $table->dropColumn('apply_start_date');
            $table->dropColumn('apply_end_date');
        });

        Schema::table('chart_of_account', function (Blueprint $table) {
            $table->unsignedBigInteger('title_id')->nullable()->default(null);

            $table->foreign('title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chart_of_account', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('transaction_id')->nullable()->default(null);

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('transaction_id')->references('id')->on('accounting_transaction')->onDelete('set null');
        });

        Schema::table('chart_of_account', function (Blueprint $table) {
            $table->date('apply_start_date');
            $table->date('apply_end_date');
        });
    }
}
