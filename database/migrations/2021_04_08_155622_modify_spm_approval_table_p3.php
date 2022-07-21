<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpmApprovalTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('spm_approval', function (Blueprint $table) {
            $table->unsignedBigInteger('previous_request')->nullable()->default(null);
            $table->unsignedBigInteger('next_request')->nullable()->default(null);

            $table->foreign('previous_request')->references('id')->on('spm_approval')->onDelete('set null');
            $table->foreign('next_request')->references('id')->on('spm_approval')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spm_approval', function (Blueprint $table) {
            $table->dropColumn('previous_request');
            $table->dropColumn('next_request');
        });
    }
}
