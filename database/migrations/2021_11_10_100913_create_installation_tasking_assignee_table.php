<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationTaskingAssigneeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('installation_tasking_assignee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('survey_tasking_id')->nullable()->default(null);
            $table->unsignedBigInteger('assignor')->nullable()->default(null);
            $table->unsignedBigInteger('assignee')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('survey_tasking_id')->references('id')->on('survey_tasking')->onDelete('set null');
            $table->foreign('assignor')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('assignee')->references('id')->on('employee')->onDelete('set null');
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
        Schema::dropIfExists('installation_tasking_assignee');
    }
}
