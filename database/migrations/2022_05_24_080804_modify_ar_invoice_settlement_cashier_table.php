<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceSettlementCashierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_settlement_cashier', function (Blueprint $table) {
            $table->unsignedBigInteger('cash_bank_id')->nullable()->default(null);
            $table->foreign('cash_bank_id')->references('id')->on('cash_bank')->onDelete('set null');
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
