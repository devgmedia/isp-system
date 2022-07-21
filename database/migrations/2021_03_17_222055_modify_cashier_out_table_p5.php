<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierOutTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_id')->nullable()->default(null);

            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_account')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropForeign('cashier_out_chart_of_account_id_foreign');
        });

        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropColumn('chart_of_account_id');
        });
    }
}
