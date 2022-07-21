<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_v2', function (Blueprint $table) {
            $table->string('invoice_phone')->nullable();
            $table->string('invoice_cp')->nullable();
            $table->boolean('qr_code')->nullable();
            $table->boolean('memo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_v2', function (Blueprint $table) {
            $table->dropColumn('invoice_phone');
            $table->dropColumn('invoice_cp');
            $table->dropColumn('qr_code');
            $table->dropColumn('memo');
        });
    }
}
