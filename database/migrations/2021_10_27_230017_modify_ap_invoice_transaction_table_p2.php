<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceTransactionTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ap_invoice_transaction', function (Blueprint $table) {
            $table->dropForeign('ap_invoice_transaction_chart_of_account_id_foreign');
            $table->dropForeign('ap_invoice_transaction_chart_of_account_card_id_foreign');
        });

        Schema::table('ap_invoice_transaction', function (Blueprint $table) {
            $table->dropColumn('chart_of_account_id');
            $table->dropColumn('chart_of_account_card_id');
        });

        Schema::table('ap_invoice_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('debit_coa_id')->nullable()->default(null);
            $table->unsignedBigInteger('debit_coa_card_id')->nullable()->default(null);

            $table->unsignedBigInteger('credit_coa_id')->nullable()->default(null);
            $table->unsignedBigInteger('credit_coa_card_id')->nullable()->default(null);

            $table->foreign('debit_coa_id')->references('id')->on('chart_of_account')->onDelete('set null');
            $table->foreign('debit_coa_card_id')->references('id')->on('chart_of_account_card')->onDelete('set null');

            $table->foreign('credit_coa_id')->references('id')->on('chart_of_account')->onDelete('set null');
            $table->foreign('credit_coa_card_id')->references('id')->on('chart_of_account_card')->onDelete('set null');
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
