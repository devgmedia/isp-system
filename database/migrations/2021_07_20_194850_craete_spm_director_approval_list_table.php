<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CraeteSpmDirectorApprovalListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('spm_director_approval_list', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('approval_id')->nullable()->default(null);
            $table->foreign('approval_id')->references('id')->on('spm_director_approval')->onDelete('set null');

            $table->unsignedBigInteger('spm_id')->nullable()->default(null);
            $table->foreign('spm_id')->references('id')->on('spm')->onDelete('set null');
            $table->string('spm_approval_id')->nullable()->default(null);
            $table->foreign('spm_approval_id')->references('approval_id')->on('spm')->onDelete('set null');

            $table->timestamps();
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
