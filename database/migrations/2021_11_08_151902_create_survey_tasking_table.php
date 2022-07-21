<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyTaskingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_tasking', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('survey_request_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);

            $table->timestamps();

            $table->foreign('survey_request_id')->references('id')->on('survey_request')->onDelete('set null');
            $table->foreign('pre_customer_id')->references('id')->on('pre_customer')->onDelete('set null');
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
        Schema::dropIfExists('survey_tasking');
    }
}
