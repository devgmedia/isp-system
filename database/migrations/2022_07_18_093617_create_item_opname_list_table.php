<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemOpnameListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('item_opname_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_opname_id')->nullable()->default(null);
            $table->unsignedBigInteger('item_id')->nullable()->default(null);
            $table->date('date_opname')->nullable()->default(null);
            $table->unsignedBigInteger('location_branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('location_regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('location_company_id')->nullable()->default(null);
            $table->unsignedBigInteger('location_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('location_employee_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('item_opname_id')->references('id')->on('item_opname')->onDelete('set null');
            $table->foreign('item_id')->references('id')->on('item')->onDelete('set null');
            $table->foreign('location_branch_id')->references('id')->on('item')->onDelete('set null');
            $table->foreign('location_regional_id')->references('id')->on('item')->onDelete('set null');
            $table->foreign('location_company_id')->references('id')->on('item')->onDelete('set null');
            $table->foreign('location_customer_id')->references('id')->on('item')->onDelete('set null');
            $table->foreign('location_employee_id')->references('id')->on('item')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_opname_list');
    }
}
