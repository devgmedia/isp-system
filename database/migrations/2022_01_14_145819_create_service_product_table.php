<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id')->nullable()->default(null);
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('service')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_product');
    }
}
