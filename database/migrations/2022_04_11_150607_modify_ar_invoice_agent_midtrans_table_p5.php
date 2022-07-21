<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceAgentMidtransTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_agent_midtrans', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_agent_midtrans_payment_method_type_id_foreign');
            $table->dropColumn('payment_method_type_id');
            $table->unsignedBigInteger('payment_method_id')->nullable()->default(null);
            $table->foreign('payment_method_id')->references('id')->on('payment_method')->onDelete('set null');
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
