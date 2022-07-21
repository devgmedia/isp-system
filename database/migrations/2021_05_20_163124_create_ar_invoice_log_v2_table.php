<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceLogV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_log_v2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('time');
            $table->string('title');
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->longText('ar_invoice_data')->nullable()->default(null);
            $table->unsignedBigInteger('caused_by')->nullable()->default(null);

            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice_v2')->onDelete('set null');
            $table->foreign('caused_by')->references('id')->on('employee')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_log_v2');
    }
}
