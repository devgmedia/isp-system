<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceTableP8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->dropColumn([
                'price_after_discount',
                'price_with_ppn',
                'previous_price_after_discount',
                'previous_price_with_ppn',
            ]);
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
            $table->float('price_after_discount', 15, 2)->nullable()->default(null);
            $table->float('price_with_ppn', 15, 2)->nullable()->default(null);
            $table->float('previous_price_after_discount', 15, 2)->nullable()->default(null);
            $table->float('previous_price_with_ppn', 15, 2)->nullable()->default(null);
        });
    }
}
