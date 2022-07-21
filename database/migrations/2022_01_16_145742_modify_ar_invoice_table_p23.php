<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP23 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('faktur_id')->nullable()->default(null);             
            $table->foreign('faktur_id')->references('id')->on('ar_invoice_faktur')->onDelete('set null'); 

            $table->boolean('qrcode')->nullable()->default(null);

            $table->float('tax_base_bandwidth', 15, 2)->nullable()->default(0);
            $table->float('tax_base_colocation', 15, 2)->nullable()->default(0);
            $table->float('tax_base_installation', 15, 2)->nullable()->default(0);
            $table->float('tax_base_device', 15, 2)->nullable()->default(0);
            $table->float('tax_base_other', 15, 2)->nullable()->default(0);
            $table->float('tax_base_application', 15, 2)->nullable()->default(0);

            $table->date('period_start_date')->nullable()->default(null);
            $table->date('period_end_date')->nullable()->default(null);

            $table->float('tax_base_usd', 15, 2)->nullable()->default(0);
            $table->float('tax_base_sgd', 15, 2)->nullable()->default(0);
            
            $table->float('tax_usd', 15, 2)->nullable()->default(0);
            $table->float('tax_sgd', 15, 2)->nullable()->default(0);
            
            $table->float('total_usd', 15, 2)->nullable()->default(0);
            $table->float('total_sgd', 15, 2)->nullable()->default(0);            
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
