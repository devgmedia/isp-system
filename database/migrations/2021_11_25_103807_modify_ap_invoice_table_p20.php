<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceTableP20 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('memo_ar_invoice_id')->nullable()->default(null);
            $table->foreign('memo_ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
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
