<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceSchemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_scheme', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payer')->nullable()->default(NULL);
            $table->unsignedBigInteger('payment_scheme_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('payer')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('payment_scheme_id')->references('id')->on('payment_scheme')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_scheme');
    }
}
