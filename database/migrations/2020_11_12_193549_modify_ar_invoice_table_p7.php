<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP7 extends Migration
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
            $table->dropColumn('midtrans_order_id');
            $table->dropColumn('midtrans_payment_type');
            $table->dropColumn('midtrans_transaction_status');
            $table->dropColumn('midtrans_fraud_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->string('midtrans_order_id')->unique()->nullable()->default(null);
            $table->string('midtrans_payment_type')->nullable()->default(null);
            $table->string('midtrans_transaction_status')->nullable()->default(null);
            $table->string('midtrans_fraud_status')->nullable()->default(null);
        });
    }
}
