<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rab', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();

            $table->string('number')->nullable()->default(NULL);
            $table->date('date')->nullable()->default(NULL);
            $table->unsignedBigInteger('survey_reporting_coverage_id')->nullable()->default(NULL);
            $table->text('approval_token')->nullable()->default(NULL);
            $table->string('sales_name')->nullable()->default(NULL);

            $table->unsignedBigInteger('marketing_approved_by')->nullable()->default(NULL);
            $table->date('marketing_approved_date')->nullable()->default(NULL);
            $table->string('marketing_approved_name')->nullable()->default(NULL);

            $table->unsignedBigInteger('finance_approved_by')->nullable()->default(NULL);
            $table->date('finance_approved_date')->nullable()->default(NULL);
            $table->string('finance_approved_name')->nullable()->default(NULL);

            $table->unsignedBigInteger('director_approved_by')->nullable()->default(NULL);
            $table->date('director_approved_date')->nullable()->default(NULL);
            $table->string('director_approved_name')->nullable()->default(NULL);

            $table->integer('total')->nullable()->default(NULL);

            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('sub_department_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('department_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('division_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('survey_reporting_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(NULL);

            $table->timestamps();

            $table->foreign('survey_reporting_coverage_id')->references('id')->on('survey_reporting_coverage')->onDelete('set null');
            $table->foreign('marketing_approved_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('finance_approved_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('director_approved_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('sub_department_id')->references('id')->on('sub_department')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('department')->onDelete('set null');
            $table->foreign('division_id')->references('id')->on('division')->onDelete('set null');
            $table->foreign('survey_reporting_id')->references('id')->on('survey_reporting')->onDelete('set null');
            $table->foreign('pre_customer_id')->references('id')->on('pre_customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rab');
    }
}
