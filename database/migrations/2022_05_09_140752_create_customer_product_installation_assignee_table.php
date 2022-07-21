<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductInstallationAssigneeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('customer_product_installation_assignee', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('customer_product_id')->nullable()->default(null);
            $table->foreign('customer_product_id', 'cus_pro_ins_ass_cus_pro_id_foreign')->references('id')->on('customer_product')->onDelete('set null');

            $table->unsignedBigInteger('employee_id')->nullable()->default(null);
            $table->foreign('employee_id', 'cus_pro_ins_ass_emp_id_foreign')->references('id')->on('employee')->onDelete('set null');

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
        //
    }
}
