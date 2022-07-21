<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpmBranchManagerApprovalTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spm_branch_manager_approval_list', function (Blueprint $table) {
            $table->dropForeign('spm_branch_manager_approval_list_spm_approval_id_foreign');
        });

        Schema::table('spm_branch_manager_approval_list', function (Blueprint $table) {
            $table->foreign('spm_approval_id')->references('approval_id')->on('spm')->onDelete('set null')->onUpdate('set null');
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
