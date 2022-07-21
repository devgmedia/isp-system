<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpmApprovalTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('spm_approval', function (Blueprint $table) {
            $table->unsignedBigInteger('first_request')->nullable()->default(null);

            $table->foreign('first_request')->references('id')->on('spm_approval')->onDelete('set null');
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
            $table->dropColumn('first_request');
        });
    }
}
