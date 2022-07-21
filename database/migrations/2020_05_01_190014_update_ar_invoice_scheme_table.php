<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceSchemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_scheme', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_scheme_payer_foreign');
        });

        Schema::table('ar_invoice_scheme', function (Blueprint $table) {
            $table->unsignedBigInteger('payer')->nullable(false)->change();
        });

        Schema::table('ar_invoice_scheme', function (Blueprint $table) {
            $table->foreign('payer')->references('id')->on('customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_scheme', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_scheme_payer_foreign');
        });

        Schema::table('ar_invoice_scheme', function (Blueprint $table) {
            $table->unsignedBigInteger('payer')->nullable()->default(null)->change();
        });

        Schema::table('ar_invoice_scheme', function (Blueprint $table) {
            $table->foreign('payer')->references('id')->on('customer')->onDelete('set null');
        });
    }
}
