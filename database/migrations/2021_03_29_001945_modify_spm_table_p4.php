<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpmTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spm', function (Blueprint $table) {
            $table->unsignedInteger('paid_total');
            $table->unique('approval_id');
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
            $table->dropColumn('paid_total');
            $table->dropUnique('spm_approval_id_unique');
        });
    }
}
