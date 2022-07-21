<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP27 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->string('billing_npwp_number')->nullable()->default(null);
            $table->string('billing_npwp_on_behalf_of')->nullable()->default(null);
            $table->string('billing_phone_number')->nullable()->default(null);
            $table->string('billing_email')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
