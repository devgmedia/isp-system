<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerRequestChangeLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('pre_customer_request_change_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('time');
            $table->string('title');
            $table->unsignedBigInteger('pre_customer_request_id')->nullable()->default(null);
            $table->longText('pre_customer_request_data')->nullable()->default(null);
            $table->unsignedBigInteger('caused_by')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('pre_customer_request_id')->references('id')->on('pre_customer_request')->onDelete('set null');
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
        Schema::dropIfExists('pre_customer_request_change_log');
    }
}
