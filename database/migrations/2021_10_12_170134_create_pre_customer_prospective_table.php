<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerProspectiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_customer_prospective', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('prospective_by')->nullable()->default(NULL);
            $table->date('prospective_date')->nullable()->default(NULL);
            $table->string('prospective_name')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('pre_customer_id')->references('id')->on('pre_customer')->onDelete('set null');
            $table->foreign('prospective_by')->references('id')->on('employee')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_customer_prospective');
    }
}
