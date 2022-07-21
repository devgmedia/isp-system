<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_visit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('report');
            $table->unsignedBigInteger('customer_id')->nullable()->default(NULL);
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
           
            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            
            $table->unsignedBigInteger('employee_id')->nullable()->default(NULL);
            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('set null');
            
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
        Schema::dropIfExists('customer_visit');
    }
}
