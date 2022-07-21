<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialQuestionAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trial_question_answer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trial_reporting_id')->nullable()->default(null);
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('question_id')->nullable()->default(null);
            $table->boolean('question_answer')->nullable()->default(null);
            $table->text('question_answer_description')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('trial_reporting_id')->references('id')->on('trial_reporting')->onDelete('set null');
            $table->foreign('pre_customer_id')->references('id')->on('pre_customer')->onDelete('set null');
            $table->foreign('question_id')->references('id')->on('trial_question')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trial_question_answer');
    }
}
