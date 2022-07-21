<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalApInvoiceTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('journal_ap_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('journal_id')->nullable()->default(null);
            $table->unsignedBigInteger('ap_invoice_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('journal_id')->references('id')->on('journal')->onDelete('set null');
            $table->foreign('ap_invoice_id')->references('id')->on('ap_invoice')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_ap_invoice');
    }
}
