<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTaxOutTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tax_out', function (Blueprint $table) {
            $table->dropForeign('tax_out_ar_invoice_id_foreign');
        });

        Schema::table('tax_out', function (Blueprint $table) {
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice_v2')->onDelete('set null');
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
