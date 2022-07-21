<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceTableP8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->float('retention', 15, 2)->nullable()->default(null)->change();
            $table->float('stamp_duty', 15, 2)->nullable()->default(null)->change();
            $table->float('discount', 15, 2)->nullable()->default(null)->change();
            $table->float('pph_pasal_23', 15, 2)->nullable()->default(null)->change();
            $table->float('pph_pasal_4_ayat_2', 15, 2)->nullable()->default(null)->change();
            $table->float('paid_total', 15, 2)->nullable()->default(null)->change();
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
            $table->unsignedInteger('retention')->nullable()->default(null)->change();
            $table->unsignedInteger('stamp_duty')->nullable()->default(null)->change();
            $table->unsignedInteger('discount')->nullable()->default(null)->change();
            $table->unsignedInteger('pph_pasal_23')->nullable()->default(null)->change();
            $table->unsignedInteger('pph_pasal_4_ayat_2')->nullable()->default(null)->change();
            $table->unsignedInteger('paid_total')->nullable()->default(null)->change();
        });
    }
}
