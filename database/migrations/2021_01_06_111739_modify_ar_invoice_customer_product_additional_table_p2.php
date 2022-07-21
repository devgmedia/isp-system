<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceCustomerProductAdditionalTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->renameColumn('ppn', 'tax');
            $table->renameColumn('dpp', 'tax_base');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->renameColumn('tax', 'ppn');
            $table->renameColumn('tax_base', 'dpp');
        });
    }
}
