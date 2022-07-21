<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpmTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spm', function (Blueprint $table) {
            $table->string('branch_manager_approval_note')->nullable()->default(null);
            $table->string('finance_approval_note')->nullable()->default(null);
            $table->string('director_approval_note')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spm', function (Blueprint $table) {
            $table->dropColumn('branch_manager_approval_note');
            $table->dropColumn('finance_approval_note');
            $table->dropColumn('director_approval_note');
        });
    }
}
