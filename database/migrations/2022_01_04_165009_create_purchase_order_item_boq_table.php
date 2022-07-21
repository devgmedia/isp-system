<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemBoqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('purchase_order_item_boq', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('boq_item_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_product_id')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);
            $table->integer('quantity')->nullable()->default(null);
            $table->unsignedBigInteger('unit_id')->nullable()->default(null);

            $table->foreign('unit_id')->references('id')->on('boq_unit')->onDelete('set null');
            $table->foreign('boq_item_id')->references('id')->on('boq_item')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('item_brand')->onDelete('set null');
            $table->foreign('brand_product_id')->references('id')->on('item_brand_product')->onDelete('set null');
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
        Schema::dropIfExists('purchase_order_item_boq');
    }
}
