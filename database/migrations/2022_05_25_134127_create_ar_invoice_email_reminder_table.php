<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceEmailReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('ar_invoice_email_reminder', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');

            $table->unsignedBigInteger('sent_by')->nullable()->default(null);
            $table->foreign('sent_by')->references('id')->on('employee')->onDelete('set null');

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
