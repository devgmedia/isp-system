<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceTableP9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('source_id')->nullable()->default(null);
            $table->foreign('source_id')->references('id')->on('ap_invoice_source')->onDelete('set null');
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
            $table->dropForeign('source_id_foreign');
        });

        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->dropColumn('source_id');
        });
    }
}
