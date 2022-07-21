<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertArInvoiceTableP11 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->dropUnique('ar_invoice_uuid_unique');
        });

        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->string('uuid')->unique()->nullable()->default(null)->change();
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
            $table->dropUnique('ar_invoice_uuid_unique');
        });
        
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->string('uuid')->unique()->default(null)->change();
        });
    }
}
