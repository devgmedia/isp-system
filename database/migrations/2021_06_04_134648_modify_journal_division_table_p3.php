<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalDivisionTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_in_category', function (Blueprint $table) {
            $table->dropForeign('cashier_in_category_journal_division_id_foreign');
        });

        Schema::table('cashier_in_category', function (Blueprint $table) {
            $table->renameColumn('journal_division_id', 'accounting_division_category_id');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropForeign('journal_division_id_foreign');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->renameColumn('division_id', 'accounting_division_category_id');
        });

        Schema::table('journal_division', function (Blueprint $table) {
            $table->dropForeign('journal_division_branch_id_foreign');
            $table->dropForeign('journal_division_chart_of_account_title_id_foreign');

            $table->dropUnique('journal_division_name_branch_id_unique');
            $table->dropUnique('journal_division_name_chart_of_account_title_id_unique');
        });

        Schema::rename('journal_division', 'accounting_division_category');

        Schema::table('cashier_in_category', function (Blueprint $table) {
            $table->foreign('accounting_division_category_id')->references('id')->on('accounting_division_category')->onDelete('set null');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->foreign('accounting_division_category_id')->references('id')->on('accounting_division_category')->onDelete('set null');
        });

        Schema::table('accounting_division_category', function (Blueprint $table) {
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');

            $table->unique(['name', 'branch_id']);
            $table->unique(['name', 'chart_of_account_title_id'], 'acc_div_cat_nam_cha_of_acc_tit_id_unique');
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
