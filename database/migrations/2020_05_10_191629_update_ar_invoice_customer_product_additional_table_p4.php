<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerProductAdditionalTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->date('billing_start_date')->nullable()->default(null);
            $table->date('billing_end_date')->nullable()->default(null);

            $table->float('price', 15, 2);
            $table->float('discount', 15, 2);
            $table->float('price_after_discount', 15, 2);
            $table->float('ppn', 15, 2);
            $table->float('dpp', 15, 2);
            $table->float('price_with_ppn', 15, 2);
            $table->float('total', 15, 2);
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
            $table->dropColumn([
                'billing_start_date',
                'billing_end_date',
            ]);

            $table->dropColumn([
                'price',
                'discount',
                'price_after_discount',
                'ppn',
                'dpp',
                'price_with_ppn',
                'total',
            ]);
        });
    }
}
