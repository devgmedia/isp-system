<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_customer');
    }
}
