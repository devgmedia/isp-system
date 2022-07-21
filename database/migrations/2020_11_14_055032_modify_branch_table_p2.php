<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBranchTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('branch', function (Blueprint $table) {
            $table->dropUnique('branch_code_unique');
            $table->dropUnique('branch_name_company_id_unique');
            $table->unique(['name', 'regional_id']);
            $table->unique(['code', 'regional_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch', function (Blueprint $table) {
            $table->dropUnique('branch_code_regional_unique');
            $table->dropUnique('branch_name_regional_id_unique');
            $table->unique(['name', 'company_id']);
            $table->unique(['code']);
        });
    }
}
