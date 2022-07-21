<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyInstallationTaskingIdToInstallationTaskingAssigneeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('installation_tasking_assignee', function (Blueprint $table) {
            $table->dropForeign('installation_tasking_assignee_survey_tasking_id_foreign');

            $table->renameColumn('survey_tasking_id', 'installation_tasking_id')->nullable()->default(null);

            $table->foreign('installation_tasking_id')->references('id')->on('installation_tasking')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installation_tasking_assignee', function (Blueprint $table) {
            //
        });
    }
}
