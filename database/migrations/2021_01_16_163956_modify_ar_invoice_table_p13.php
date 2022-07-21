<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP13 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->boolean('receipt_email_sent')->nullable()->default(false);
            $table->datetime('receipt_email_sent_at')->nullable()->default(null);
            $table->boolean('receipt_whatsapp_sent')->nullable()->default(false);
            $table->datetime('receipt_whatsapp_sent_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->dropColumn('receipt_email_sent');
            $table->dropColumn('receipt_email_sent_at');
            $table->dropColumn('receipt_whatsapp_sent');
            $table->dropColumn('receipt_whatsapp_sent_at');
        });
    }
}
