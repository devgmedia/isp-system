<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceWhatsappReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('ar_invoice_whatsapp_reminder', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->unsignedBigInteger('broadcast_job_id')->nullable()->default(null);

            $table->tinyInteger('log_status')->nullable()->default(null);

            $table->string('broadcast_name')->nullable()->default(null);
            $table->tinyInteger('job_status')->nullable()->default(null);

            $table->tinyInteger('job_total_failed')->nullable()->default(null);
            $table->tinyInteger('job_total_read')->nullable()->default(null);
            $table->tinyInteger('job_total_received')->nullable()->default(null);
            $table->tinyInteger('job_total_recipient')->nullable()->default(null);
            $table->tinyInteger('job_total_sent')->nullable()->default(null);

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
        Schema::dropIfExists('ar_invoice_whatsapp_reminder');
    }
}
