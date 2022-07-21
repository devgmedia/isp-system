<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceTableP10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->dropColumn('paid_total');
            $table->dropColumn('paid');
            $table->dropColumn('paid_at');
            $table->dropColumn('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->float('paid_total', 15, 2)->nullable()->default(0);
            $table->boolean('paid')->nullable()->default(null);
            $table->datetime('paid_at')->nullable()->default(null);
            $table->date('payment_date')->nullable()->default(null);
        });
    }
}
