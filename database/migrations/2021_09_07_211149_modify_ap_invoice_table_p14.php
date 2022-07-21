<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceTableP14 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->float('retention', 15, 2)->nullable()->default(0)->change();
            $table->float('stamp_duty', 15, 2)->nullable()->default(0)->change();
            $table->float('discount', 15, 2)->nullable()->default(0)->change();

            $table->float('pph_pasal_21', 15, 2)->nullable()->default(0)->change();
            $table->float('pph_pasal_23', 15, 2)->nullable()->default(0)->change();
            $table->float('pph_pasal_4_ayat_2', 15, 2)->nullable()->default(0)->change();
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
