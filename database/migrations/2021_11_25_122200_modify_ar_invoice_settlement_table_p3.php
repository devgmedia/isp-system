<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceSettlementTableP3 extends Migration
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
            $table->dropForeign('ar_invoice_settlement_purpose_id_foreign');
            $table->dropForeign('ar_invoice_settlement_ar_invoice_gmedia_id_foreign');
        });

        Schema::table('ar_invoice_settlement', function (Blueprint $table) {
            $table->dropColumn('purpose_id');
            $table->dropColumn('paid_total');
            $table->dropColumn('locked_by_invoice');
            $table->dropColumn('ar_invoice_gmedia_id');

            $table->boolean('memo')->nullable()->default(null);
            $table->boolean('memo_confirm')->nullable()->default(null);

            $table->float('invoice', 15, 2)->nullable()->default(0);
            $table->float('admin', 15, 2)->nullable()->default(0);
            $table->float('down_payment', 15, 2)->nullable()->default(0);
            $table->float('marketing_fee', 15, 2)->nullable()->default(0);
            $table->float('pph_pasal_22', 15, 2)->nullable()->default(0);
            $table->float('pph_pasal_23', 15, 2)->nullable()->default(0);
            $table->float('ppn', 15, 2)->nullable()->default(0);

            $table->float('total', 15, 2)->nullable()->default(0);
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
