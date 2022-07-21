<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierOutTableP9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->string('fixcost_category_name')->nullable()->default(null);
            $table->string('division_category_name')->nullable()->default(null);
        });

        // category
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropForeign('cashier_out_fixcost_category_id_foreign');
        });

        Schema::table('cashier_out_fixcost_category', function (Blueprint $table) {
            $table->dropUnique('cashier_out_fixcost_category_name_unique');
        });

        Schema::rename('cashier_out_fixcost_category', 'cashier_out_category');

        Schema::table('cashier_out', function (Blueprint $table) {
            $table->renameColumn('fixcost_category_id', 'category_id');
        });

        Schema::table('cashier_out', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('cashier_out_category')->onDelete('set null');
        });

        // accounting_division_category
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropForeign('cashier_out_division_category_id_foreign');
        });

        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropColumn('division_category_id');
            $table->unsignedBigInteger('accounting_division_category_id')->nullable()->default(null);
            $table->foreign('accounting_division_category_id')->references('id')->on('accounting_division_category')->onDelete('set null');
        });

        Schema::dropIfExists('cashier_out_division_category');

        // chart_of_account_title
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');
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
