<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialReportingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('trial_reporting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->unsignedBigInteger('trial_request_id')->nullable()->default(null);
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('trial_request_id')->references('id')->on('trial_request')->onDelete('set null');
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
        Schema::dropIfExists('trial_reporting');
    }
}
