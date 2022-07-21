<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceDetailP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_detail', function (Blueprint $table) {
            $table->string('custom_product')->nullable();
            $table->string('custom_additional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_detail', function (Blueprint $table) {
            $table->dropColumn('custom_product');
            $table->dropColumn('custom_additional');
        });
    }
}
