<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerChangeLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('customer_change_log', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date')->nullable()->default(null);
            $table->time('time')->nullable()->default(null);
            $table->string('title')->nullable()->default(null);
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);
            $table->longText('customer_data')->nullable()->default(null);
            $table->unsignedBigInteger('employee_id')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
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
        Schema::dropIfExists('customer_change_log');
    }
}
