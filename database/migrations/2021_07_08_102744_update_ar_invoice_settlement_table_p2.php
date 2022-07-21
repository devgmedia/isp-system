<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceSettlementTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_settlement', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_gmedia_id')->nullable()->default(null);

            $table->foreign('ar_invoice_gmedia_id')->references('id')->on('ar_invoice_v2')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_settlement', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_settlement_ar_invoice_gmedia_id_foreign');
            $table->dropColumn('ar_invoice_gmedia_id');
        });
    }
}
