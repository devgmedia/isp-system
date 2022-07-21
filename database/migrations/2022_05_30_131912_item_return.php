<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('item_return', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number_spm')->nullable()->default(null);
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->foreign('brand_id')->references('id')->on('item_brand')->onDelete('set null');
            $table->unsignedBigInteger('brand_product_id')->nullable()->default(null);
            $table->foreign('brand_product_id')->references('id')->on('item_brand_product')->onDelete('set null');
            $table->unsignedBigInteger('item_type_id')->nullable()->default(null);
            $table->foreign('item_type_id')->references('id')->on('item_type')->onDelete('set null');
            $table->unsignedBigInteger('item_id')->nullable()->default(null);
            $table->foreign('item_id')->references('id')->on('item')->onDelete('set null');
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('set null');
            $table->string('name')->nullable()->default(null);
            $table->datetime('date_of_purchase')->nullable()->default(null);
            $table->datetime('date_of_return')->nullable()->default(null);
            $table->float('purchase_price', 15, 2)->nullable()->default(null);
            $table->string('note')->nullable()->default(null);
            $table->unsignedBigInteger('item_return_category_id')->nullable()->default(null);
            $table->foreign('item_return_category_id')->references('id')->on('item_return_category')->onDelete('set null');
            $table->float('return_price', 15, 2)->nullable()->default(null);
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
        //
    }
}
