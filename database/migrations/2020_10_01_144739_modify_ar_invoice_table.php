<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->float('remaining_payment', 15, 2)->nullable()->default(0);
            $table->float('previous_remaining_payment', 15, 2)->nullable()->default(0);
            $table->float('paid_total', 15, 2)->nullable()->default(0);
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
            $table->dropColumn([
                'remaining_payment',
                'previous_remaining_payment',
                'paid_total', 
            ]);
        });
    }
}
