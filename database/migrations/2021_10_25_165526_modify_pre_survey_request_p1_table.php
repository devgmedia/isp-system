<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreSurveyRequestP1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_survey_request', function (Blueprint $table) {
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(null);

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
        //
    }
}
