<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceConfirmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_confirm', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');

            $table->string('message');
            
            $table->unsignedBigInteger('submit_by')->nullable()->default(null);
            $table->foreign('submit_by')->references('id')->on('employee')->onDelete('set null');

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
        //
    }
}
