<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductTableP9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
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
