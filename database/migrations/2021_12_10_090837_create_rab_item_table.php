<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRabItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rab_item', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable()->default(null);
            $table->integer('purchasing_price')->nullable()->default(null);
            $table->integer('marketing_price')->nullable()->default(null);
            $table->integer('margin_price')->nullable()->default(null);

            $table->string('quantity')->nullable()->default(null);
            $table->unsignedBigInteger('unit_id')->nullable()->default(null);

            $table->unsignedBigInteger('rab_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_product_id')->nullable()->default(null);
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);

            $table->boolean('sales_lent')->nullable()->default(false);
            $table->boolean('sales_buy')->nullable()->default(false);

            $table->timestamps();

            $table->foreign('rab_id')->references('id')->on('rab')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('item_brand')->onDelete('set null');
            $table->foreign('brand_product_id')->references('id')->on('item_brand_product')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('rab_unit')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rab_item');
    }
}
