<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerProductTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->date('billing_start_date')->nullable()->default(null);
            $table->date('billing_end_date')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->dropColumn([
                'billing_start_date',
                'billing_end_date',
            ]);
        });
    }
}
