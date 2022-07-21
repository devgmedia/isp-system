<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->string('number')->nullable()->default(null)->change();
            $table->string('purchase_request_number')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->string('number')->change();
            $table->dropColumn('purchase_request_number');
        });
    }
}
