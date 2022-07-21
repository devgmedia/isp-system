<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_order_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('item_brand_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('item_brand_product_id')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->unsignedInteger('price');
            $table->unsignedSmallInteger('quantity');
            $table->unsignedInteger('total')->nullable()->default(NULL);
            $table->unsignedInteger('supplier_id')->nullable()->default(NULL);
            $table->unsignedInteger('purchase_request_id')->nullable()->default(NULL);
            $table->unsignedInteger('purchase_request_number')->nullable()->default(NULL);
            $table->unsignedInteger('source_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_order')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_item');
    }
}
