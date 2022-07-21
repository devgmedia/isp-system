<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductIsolationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_product_isolation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('registration_date');
            $table->unsignedBigInteger('customer_product_id')->nullable()->default(null);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_product_isolation');
    }
}
