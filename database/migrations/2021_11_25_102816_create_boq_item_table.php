<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_item', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable()->default(NULL);
            $table->integer('purchasing_price')->nullable()->default(NULL);
            $table->integer('marketing_price')->nullable()->default(NULL);
            $table->integer('margin_price')->nullable()->default(NULL);

            $table->unsignedBigInteger('boq_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('brand_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('brand_product_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('supplier_id')->nullable()->default(NULL);

            $table->boolean('sales_lent')->nullable()->default(false);
            $table->boolean('sales_buy')->nullable()->default(false);

            $table->timestamps();

            $table->foreign('boq_id')->references('id')->on('boq')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('item_brand')->onDelete('set null');
            $table->foreign('brand_product_id')->references('id')->on('item_brand_product')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boq_item');
    }
}
