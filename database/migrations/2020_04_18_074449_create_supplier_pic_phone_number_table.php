<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPicPhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_pic_phone_number', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->unsignedBigInteger('supplier_pic_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('supplier_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->unique(['number', 'supplier_id']);
            $table->foreign('supplier_pic_id')->references('id')->on('supplier_pic')->onDelete('set null');
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
        Schema::dropIfExists('supplier_pic_phone_number');
    }
}
