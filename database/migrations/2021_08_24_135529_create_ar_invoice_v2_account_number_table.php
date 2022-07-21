<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceV2AccountNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_v2_account_number', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_id');
            $table->unsignedBigInteger('bank_account_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice_v2');
            $table->foreign('bank_account_id')->references('id')->on('bank_account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_v2_account_number');
    }
}
