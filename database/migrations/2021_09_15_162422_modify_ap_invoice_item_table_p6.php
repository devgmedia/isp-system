<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceItemTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ap_invoice_item', function (Blueprint $table) {
            $table->float('discount', 15, 2)->nullable(false)->default(0);
            $table->float('retention', 15, 2)->nullable(false)->default(0);
            $table->float('tax_base', 15, 2)->nullable(false)->default(0);
            $table->float('tax', 15, 2)->nullable(false)->default(0);
            $table->float('pph_pasal_21', 15, 2)->nullable(false)->default(0);
            $table->float('pph_pasal_23', 15, 2)->nullable(false)->default(0);
            $table->float('pph_pasal_4_ayat_2', 15, 2)->nullable(false)->default(0);
            $table->float('total', 15, 2)->nullable(false)->default(0);
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
