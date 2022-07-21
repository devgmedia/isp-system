<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialTaskingAssigneeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('trial_tasking_assignee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trial_tasking_id')->nullable()->default(null);
            $table->unsignedBigInteger('assignor')->nullable()->default(null);
            $table->unsignedBigInteger('assignee')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('trial_tasking_id')->references('id')->on('trial_tasking')->onDelete('set null');
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
        Schema::dropIfExists('trial_tasking_assignee');
    }
}
