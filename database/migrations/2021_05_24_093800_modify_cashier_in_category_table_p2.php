<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierInCategoryTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_in_category', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');

            $table->unsignedBigInteger('chart_of_account_id')->nullable()->default(null);
            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_account')->onDelete('set null');

            $table->unsignedBigInteger('chart_of_account_card_id')->nullable()->default(null);
            $table->foreign('chart_of_account_card_id')->references('id')->on('chart_of_account_card')->onDelete('set null');

            $table->dropUnique('cashier_in_category_name_unique');
            $table->unique(['name', 'chart_of_account_title_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashier_in_category', function (Blueprint $table) {
            //
        });
    }
}
