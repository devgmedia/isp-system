<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductCustomerRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_product_customer_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('customer_product_id')->nullable()->default(null);
            $table->unsignedBigInteger('employee_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_product_customer_relation');
    }
}
