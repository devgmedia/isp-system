<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpmApprovalTableP2 extends Migration
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
            $table->unsignedBigInteger('request_by')->nullable()->default(null);
            $table->datetime('request_at')->nullable()->default(null);

            $table->foreign('request_by')->references('id')->on('employee')->onDelete('set null');
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
            $table->dropColumn('request_by');
            $table->dropColumn('request_at');
        });
    }
}
