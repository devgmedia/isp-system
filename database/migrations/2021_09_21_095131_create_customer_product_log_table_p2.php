<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductLogTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('customer_product_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('time');
            $table->string('title');
            $table->unsignedBigInteger('customer_product_id')->nullable()->default(null);
            $table->longText('customer_product_data')->nullable()->default(null);
            $table->unsignedBigInteger('caused_by')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
            $table->foreign('caused_by')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_product_log');
    }
}
