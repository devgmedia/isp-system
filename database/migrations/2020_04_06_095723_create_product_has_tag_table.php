<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductHasTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_has_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->unsignedBigInteger('tag_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product')->onDelete('set null');
            $table->foreign('tag_id')->references('id')->on('product_tag')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_has_tag');
    }
}
