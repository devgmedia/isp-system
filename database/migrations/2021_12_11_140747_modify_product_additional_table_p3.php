<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductAdditionalTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_additional', function (Blueprint $table) {
            $table->string('uuid');
            $table->unsignedBigInteger('ar_invoice_item_category_id')->nullable()->default(null);
            $table->foreign('ar_invoice_item_category_id')->references('id')->on('ar_invoice_item_category')->onDelete('set null');
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
