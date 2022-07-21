<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpmApprovalListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spm_approval_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('spm_approval_id')->nullable()->default(null);
            $table->unsignedBigInteger('spm_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['spm_approval_id', 'spm_id']);

            $table->foreign('spm_approval_id')->references('id')->on('spm_approval')->onDelete('set null');
            $table->foreign('spm_id')->references('id')->on('spm')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spm_approval_list');
    }
}
