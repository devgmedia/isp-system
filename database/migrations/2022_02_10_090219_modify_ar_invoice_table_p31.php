<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP31 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->float('settlement_invoice', 15, 2)->nullable()->default(0);
            $table->float('settlement_admin', 15, 2)->nullable()->default(0);
            $table->float('settlement_down_payment', 15, 2)->nullable()->default(0);
            $table->float('settlement_marketing_fee', 15, 2)->nullable()->default(0);
            $table->float('settlement_pph_pasal_22', 15, 2)->nullable()->default(0);
            $table->float('settlement_pph_pasal_23', 15, 2)->nullable()->default(0);
            $table->float('settlement_ppn', 15, 2)->nullable()->default(0);
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
