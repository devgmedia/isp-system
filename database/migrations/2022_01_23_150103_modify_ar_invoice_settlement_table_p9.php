<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceSettlementTableP9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_settlement', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->foreign('product_id')->references('id')->on('product')->onDelete('set null');

            $table->unsignedBigInteger('customer_category_id')->nullable()->default(null);
            $table->foreign('customer_category_id')->references('id')->on('customer_category')->onDelete('set null');
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
