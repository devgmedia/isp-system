<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('purchase_request_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_request_id')->nullable()->default(null);
            $table->unsignedBigInteger('item_brand_id')->nullable()->default(null);
            $table->unsignedBigInteger('item_brand_product_id')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->unsignedInteger('price');
            $table->unsignedSmallInteger('quantity');
            $table->unsignedInteger('total')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('purchase_request_id')->references('id')->on('purchase_request')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_request_item');
    }
}
