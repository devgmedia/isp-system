<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMovementListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('item_movement_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('movement_id')->nullable()->default(null);
            $table->unsignedBigInteger('item_id')->nullable()->default(null);

            $table->unsignedBigInteger('from_warehouse_id')->nullable()->default(null);

            $table->unsignedBigInteger('from_ownership_branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_ownership_regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_ownership_company_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_ownership_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_ownership_employee_id')->nullable()->default(null);

            $table->unsignedBigInteger('from_condition_category_id')->nullable()->default(null);

            $table->unsignedBigInteger('to_warehouse_id')->nullable()->default(null);

            $table->unsignedBigInteger('to_ownership_branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('to_ownership_regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('to_ownership_company_id')->nullable()->default(null);
            $table->unsignedBigInteger('to_ownership_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('to_ownership_employee_id')->nullable()->default(null);

            $table->unsignedBigInteger('to_condition_category_id')->nullable()->default(null);

            $table->foreign('movement_id')->references('id')->on('item_movement')->onDelete('set null');
            $table->foreign('item_id')->references('id')->on('item')->onDelete('set null');

            $table->foreign('from_ownership_branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('from_ownership_regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('from_ownership_company_id')->references('id')->on('company')->onDelete('set null');
            $table->foreign('from_ownership_customer_id')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('from_ownership_employee_id')->references('id')->on('employee')->onDelete('set null');

            $table->foreign('from_condition_category_id')->references('id')->on('item_condition_category')->onDelete('set null');

            $table->foreign('to_ownership_branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('to_ownership_regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('to_ownership_company_id')->references('id')->on('company')->onDelete('set null');
            $table->foreign('to_ownership_customer_id')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('to_ownership_employee_id')->references('id')->on('employee')->onDelete('set null');

            $table->foreign('to_condition_category_id')->references('id')->on('item_condition_category')->onDelete('set null');

            $table->unsignedBigInteger('from_location_branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_location_regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_location_company_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_location_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_location_employee_id')->nullable()->default(null);

            $table->unsignedBigInteger('to_location_branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('to_location_regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('to_location_company_id')->nullable()->default(null);
            $table->unsignedBigInteger('to_location_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('to_location_employee_id')->nullable()->default(null);

            $table->foreign('from_location_branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('from_location_regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('from_location_company_id')->references('id')->on('company')->onDelete('set null');
            $table->foreign('from_location_customer_id')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('from_location_employee_id')->references('id')->on('employee')->onDelete('set null');

            $table->foreign('to_location_branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('to_location_regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('to_location_company_id')->references('id')->on('company')->onDelete('set null');
            $table->foreign('to_location_customer_id')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('to_location_employee_id')->references('id')->on('employee')->onDelete('set null');

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
        Schema::dropIfExists('item_movement_list');
    }
}
