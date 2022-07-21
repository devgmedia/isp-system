<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDivisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('division', function (Blueprint $table) { 
            $table->string('pr_approval_email')->nullable()->default(NULL);
            $table->string('pr_approval_2nd_email')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('division', function (Blueprint $table) {
            $table->dropColumn('pr_approval_email');
            $table->dropColumn('pr_approval_2nd_email');
        });
    }
}
