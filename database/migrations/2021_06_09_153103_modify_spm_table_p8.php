<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpmTableP8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('spm', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');
        });

        Schema::table('spm', function (Blueprint $table) {
            $table->string('fixcost_category_name')->nullable()->default(null);
            $table->string('division_category_name')->nullable()->default(null);
        });

        Schema::table('spm', function (Blueprint $table) {
            $table->dropForeign('spm_fixcost_category_id_foreign');
            $table->dropForeign('spm_division_category_id_foreign');
        });

        Schema::dropIfExists('spm_fixcost_category');
        Schema::dropIfExists('spm_division_category');

        Schema::table('spm', function (Blueprint $table) {
            $table->renameColumn('fixcost_category_id', 'cashier_out_category_id');
            $table->renameColumn('division_category_id', 'accounting_division_category_id');
        });

        Schema::table('spm', function (Blueprint $table) {
            $table->foreign('cashier_out_category_id', 'spm_cas_ou_cat_id_foreign')->references('id')->on('cashier_out_category')->onDelete('set null');
            $table->foreign('accounting_division_category_id', 'spm_acc_div_cat_id_foreign')->references('id')->on('accounting_division_category')->onDelete('set null');
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
