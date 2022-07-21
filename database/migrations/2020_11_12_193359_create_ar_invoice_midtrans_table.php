<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceMidtransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_midtrans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->string('order_id')->unique()->nullable()->default(null);
            $table->string('payment_type')->nullable()->default(null);
            $table->string('transaction_status')->nullable()->default(null);
            $table->string('fraud_status')->nullable()->default(null);            
            $table->timestamps();

            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_midtrans');
    }
}
