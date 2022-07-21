<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceSettlementTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_settlement', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_settlement_cashier_in_id_foreign');
        });

        Schema::table('ar_invoice_settlement', function (Blueprint $table) {
            $table->dropColumn('cashier_in_id');
        });

        Schema::table('ar_invoice_settlement', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');

            $table->date('date')->nullable()->default(null);

            $table->float('paid_total', 15, 2);
            $table->boolean('locked_by_invoice')->nullable()->default(false);
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
