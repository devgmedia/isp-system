<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->boolean('auto_sent_invoice_via_email')->nullable()->default(false);
            $table->boolean('auto_sent_invoice_via_whatsapp')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropColumn('auto_sent_invoice_via_email');
            $table->dropColumn('auto_sent_invoice_via_whatsapp');
        });
    }
}
