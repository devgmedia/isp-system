<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalArInvoiceTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_ar_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('journal_id')->nullable()->default(null);
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('journal_id')->references('id')->on('journal')->onDelete('set null');
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
        Schema::dropIfExists('journal_ar_invoice');
    }
}
