<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashBankTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_bank', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');
        });

        Schema::table('cash_bank', function (Blueprint $table) {
            $table->dropForeign('cash_bank_branch_id_foreign');
        });

        Schema::table('cash_bank', function (Blueprint $table) {
            $table->dropUnique('cash_bank_name_branch_id_unique');
            $table->dropUnique('cash_bank_number_unique');
        });

        Schema::table('cash_bank', function (Blueprint $table) {
            $table->unique(['name', 'chart_of_account_title_id']);
            $table->unique(['number', 'chart_of_account_title_id']);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
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
