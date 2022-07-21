<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('pre_customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('email');

            $table->unsignedBigInteger('province_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('district_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('sub_district_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('village_id')->nullable()->default(NULL);

            $table->string('address')->nullable()->default(NULL);
            $table->float('latitude', 20, 10)->nullable()->default(NULL);
            $table->float('longitude', 20, 10)->nullable()->default(NULL);

            $table->string('npwp')->nullable()->default(NULL);

            $table->unsignedBigInteger('previous_isp_id')->nullable()->default(NULL);
            $table->unsignedInteger('previous_isp_price')->nullable()->default(NULL);
            $table->unsignedInteger('previous_isp_bandwidth')->nullable()->default(NULL);
            $table->string('previous_isp_feature')->nullable()->default(NULL);
            $table->unsignedBigInteger('previous_isp_bandwidth_unit_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('previous_isp_bandwidth_type_id')->nullable()->default(NULL);

            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);

            $table->string('identity_card')->nullable()->default(NULL);
            $table->string('postal_code')->nullable()->default(NULL);
            $table->string('fax')->nullable()->default(NULL);

            $table->unsignedBigInteger('sales')->nullable()->default(NULL);
            $table->boolean('prospect')->nullable()->default(NULL);
            $table->date('update_to_prospect_date')->nullable()->default(NULL);
            $table->date('request_pre_survey_date')->nullable()->default(NULL);
            $table->date('request_survey_date')->nullable()->default(NULL);

            $table->timestamps();

            
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('village_id')->references('id')->on('village')->onDelete('set null');

            $table->foreign('previous_isp_id')->references('id')->on('isp')->onDelete('set null');

            $table->foreign('previous_isp_bandwidth_unit_id')->references('id')->on('bandwidth_unit')->onDelete('set null');
            $table->foreign('previous_isp_bandwidth_type_id')->references('id')->on('bandwidth_type')->onDelete('set null');
            
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('sales')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_customer');
    }
}
