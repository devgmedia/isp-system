<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceSettlementTableP8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_settlement', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->default(null);
            $table->string('sid')->nullable()->default(null);
            $table->string('cid')->nullable()->default(null);
            $table->string('customer_name')->nullable()->default(null);
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
