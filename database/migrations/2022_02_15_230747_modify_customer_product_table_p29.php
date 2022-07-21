<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP29 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->datetime('installation_invoice_whatsapp_at')->nullable()->default(null);
            $table->datetime('installation_invoice_email_at')->nullable()->default(null);
            $table->date('installation_invoice_due_date')->nullable()->default(null);
            $table->datetime('installation_invoice_paid_at')->nullable()->default(null);
            $table->date('installation_date')->nullable()->default(null);
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
