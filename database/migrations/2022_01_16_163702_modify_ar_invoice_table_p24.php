<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP24 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('payer_category_id')->nullable()->default(null);             
            $table->foreign('payer_category_id')->references('id')->on('customer_category')->onDelete('set null'); 
            
            $table->unsignedBigInteger('memo_to')->nullable()->default(null);             
            $table->foreign('memo_to')->references('id')->on('branch')->onDelete('set null'); 

            $table->boolean('is_tax')->nullable()->default(null);
            $table->boolean('is_edited')->nullable()->default(null);
            $table->boolean('is_printed')->nullable()->default(null);       
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
