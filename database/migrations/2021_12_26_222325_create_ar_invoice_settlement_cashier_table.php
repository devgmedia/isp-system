<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceSettlementCashierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_settlement_cashier', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('ar_invoice_settlement_id')->nullable()->default(null);
            $table->foreign('ar_invoice_settlement_id', 'ar_inv_set_cas_ar_inv_set_id_foreign')->references('id')->on('ar_invoice_settlement')->onDelete('set null');

            $table->unsignedBigInteger('cashier_in_id')->nullable()->default(null);
            $table->foreign('cashier_in_id')->references('id')->on('cashier_in')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_settlement_cashier');
    }
}
