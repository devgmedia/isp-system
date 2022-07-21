<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceTableP9 extends Migration
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
            $table->datetime('paid_at')->nullable()->default(null);
            $table->datetime('email_sent_at')->nullable()->default(null);
            $table->date('payment_date')->nullable()->default(null);
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
            $table->dropColumn([
                'paid_at',
                'email_sent_at',
                'payment_date',
            ]);
        });
    }
}
