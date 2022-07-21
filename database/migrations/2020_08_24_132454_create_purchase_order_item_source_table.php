<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('purchase_order_item_source', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('item_brand_id')->nullable()->default(null);
            $table->unsignedInteger('item_brand_product_id')->nullable()->default(null);
            $table->string('name');
            $table->unsignedInteger('price');
            $table->unsignedSmallInteger('quantity');
            $table->unsignedInteger('total');
            $table->unsignedInteger('supplier_id')->nullable()->default(null);
            $table->unsignedInteger('purchase_request_id')->nullable()->default(null);
            $table->unsignedInteger('purchase_request_number')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_item_source');
    }
}
