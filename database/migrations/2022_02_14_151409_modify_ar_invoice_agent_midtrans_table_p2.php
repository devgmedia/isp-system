<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceAgentMidtransTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_agent_midtrans', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_agent_midtrans_ar_invoice_id_foreign');
            $table->dropColumn('ar_invoice_id');

            $table->string('midtrans_data')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_agent_midtrans');
    }
}
