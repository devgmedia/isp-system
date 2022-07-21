<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierInTableP9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_in', function (Blueprint $table) {
            $table->unsignedBigInteger('memo_settlement_id')->nullable()->default(null);
            $table->boolean('memo')->nullable()->default(null);

            $table->foreign('memo_settlement_id')->references('id')->on('ar_invoice_settlement')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashier_in', function (Blueprint $table) {
            //
        });
    }
}
