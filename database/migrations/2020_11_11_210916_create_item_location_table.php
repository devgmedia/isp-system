<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_location', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('time');

            $table->unsignedBigInteger('item_id')->nullable()->default(null);
            $table->unsignedBigInteger('province_id')->nullable()->default(null);
            $table->unsignedBigInteger('district_id')->nullable()->default(null);
            $table->unsignedBigInteger('sub_district_id')->nullable()->default(null);
            $table->unsignedBigInteger('village_id')->nullable()->default(null);

            $table->string('address')->nullable()->default(null);
            $table->string('latitude')->nullable()->default(null);
            $table->string('longitude')->nullable()->default(null);

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('company_id')->nullable()->default(null);
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('employee_id')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('item')->onDelete('set null');
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('village_id')->references('id')->on('village')->onDelete('set null');

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('set null');
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
        Schema::dropIfExists('item_location');
    }
}
