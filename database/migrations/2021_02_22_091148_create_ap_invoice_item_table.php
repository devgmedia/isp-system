<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApInvoiceItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ap_invoice_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ap_invoice_id')->nullable()->default(null);
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->string('name');
            $table->unsignedInteger('price');
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
        Schema::dropIfExists('ap_invoice_item');
    }
}
