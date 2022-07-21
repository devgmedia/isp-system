<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAdditionalHasTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_additional_has_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_additional_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('tag_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('product_additional_id')->references('id')->on('product_additional')->onDelete('set null');
            $table->foreign('tag_id')->references('id')->on('product_additional_tag')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_additional_has_tag');
    }
}
