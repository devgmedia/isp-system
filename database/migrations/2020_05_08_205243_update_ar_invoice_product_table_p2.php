<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceProductTableP2 extends Migration
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
        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
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
