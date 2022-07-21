<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyChartOfAccountTableP2 extends Migration
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
            $table->unsignedBigInteger('transaction_id')->nullable()->default(null);

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
        Schema::table('chart_of_account', function (Blueprint $table) {
            $table->dropForeign('chart_of_account_transaction_id_foreign');
        });

        Schema::table('chart_of_account', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
}
