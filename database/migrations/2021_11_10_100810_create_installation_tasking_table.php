<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationTaskingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_tasking', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('installation_request_id')->nullable()->default(null);
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('installation_request_id')->references('id')->on('installation_request')->onDelete('set null');
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
        Schema::dropIfExists('installation_tasking');
    }
}
