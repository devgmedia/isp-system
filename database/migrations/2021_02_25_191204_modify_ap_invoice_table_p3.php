<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->string('uuid');
            $table->unique('uuid');
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
            $table->dropUnique('ap_invoice_uuid_unique');
        });

        Schema::table('ap_invoice', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
}
