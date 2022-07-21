<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAdditionalDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_additional_discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_additional_id')->nullable()->default(null);
            $table->unsignedBigInteger('discount_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('product_additional_id')->references('id')->on('product_additional')->onDelete('set null');
            $table->foreign('discount_id')->references('id')->on('discount')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_additional_discount');
    }
}
