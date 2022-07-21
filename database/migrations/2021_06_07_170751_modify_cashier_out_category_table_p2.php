<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierOutCategoryTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_out_category', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');

            $table->unsignedBigInteger('chart_of_account_id')->nullable()->default(null);
            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_account')->onDelete('set null');

            $table->unsignedBigInteger('chart_of_account_card_id')->nullable()->default(null);
            $table->foreign('chart_of_account_card_id')->references('id')->on('chart_of_account_card')->onDelete('set null');

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');

            $table->unsignedBigInteger('accounting_menu_id')->nullable()->default(null);
            $table->foreign('accounting_menu_id')->references('id')->on('accounting_menu')->onDelete('set null');

            $table->unsignedBigInteger('accounting_division_category_id')->nullable()->default(null);
            $table->foreign('accounting_division_category_id')->references('id')->on('accounting_division_category')->onDelete('set null');

            $table->unique(['name', 'chart_of_account_title_id'], 'cas_out_cat_nam_cha_of_acc_tit_id_unique');
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
