<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cid')->unique()->nullable()->default(NULL);
            $table->string('name');
            $table->date('registration_date');

            $table->unsignedBigInteger('province_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('district_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('sub_district_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('village_id')->nullable()->default(NULL);

            $table->unsignedInteger('money')->default(0);
            $table->string('address')->nullable()->default(NULL);
            $table->float('latitude', 20, 10)->nullable()->default(NULL);
            $table->float('longitude', 20, 10)->nullable()->default(NULL);

            $table->boolean('active')->default(FALSE);
            $table->string('email')->nullable()->default(NULL);
            $table->string('npwp')->nullable()->default(NULL);

            $table->unsignedBigInteger('previous_isp_id')->nullable()->default(NULL);
            $table->unsignedInteger('previous_isp_price')->nullable()->default(NULL);
            $table->unsignedInteger('previous_isp_bandwidth')->nullable()->default(NULL);
            $table->enum('previous_isp_bandwidth_type', ['up to', 'dedicated'])->nullable()->default(NULL);
            $table->string('previous_isp_feature')->nullable()->default(NULL);
            $table->unsignedBigInteger('previous_isp_bandwidth_unit_id')->nullable()->default(NULL);

            $table->boolean('approved_by_marketing_manager')->default(FALSE);
            $table->unsignedBigInteger('approved_by_marketing_manager_id')->nullable()->default(NULL);            
            $table->date('approved_by_marketing_manager_date')->nullable()->default(NULL);

            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->unique(['name', 'branch_id']);
            $table->unique(['email', 'branch_id']);

            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('village_id')->references('id')->on('village')->onDelete('set null');

            $table->foreign('previous_isp_bandwidth_unit_id')->references('id')->on('bandwidth_unit')->onDelete('set null');
            
            $table->foreign('approved_by_marketing_manager_id')->references('id')->on('user')->onDelete('set null');

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
