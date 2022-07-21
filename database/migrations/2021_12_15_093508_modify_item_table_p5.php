<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->unsignedBigInteger('from_ownership_branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_ownership_regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_ownership_company_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_ownership_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_ownership_employee_id')->nullable()->default(null);

            $table->foreign('from_ownership_branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('from_ownership_regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('from_ownership_company_id')->references('id')->on('company')->onDelete('set null');
            $table->foreign('from_ownership_customer_id')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('from_ownership_employee_id')->references('id')->on('employee')->onDelete('set null');

            $table->unsignedBigInteger('from_location_branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_location_regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_location_company_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_location_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('from_location_employee_id')->nullable()->default(null);

            $table->foreign('from_location_branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('from_location_regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('from_location_company_id')->references('id')->on('company')->onDelete('set null');
            $table->foreign('from_location_customer_id')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('from_location_employee_id')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
