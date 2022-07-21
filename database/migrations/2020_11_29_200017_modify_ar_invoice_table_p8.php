<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->boolean('whatsapp_sent')->nullable()->default(false);
            $table->datetime('whatsapp_sent_at')->nullable()->default(null);
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
            $table->dropColumn('whatsapp_sent');
            $table->dropColumn('whatsapp_sent_at');
        });
    }
}
