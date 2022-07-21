<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerHasTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_has_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('tag_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('tag_id')->references('id')->on('customer_tag')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_has_tag');
    }
}
