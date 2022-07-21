<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySubDepartmentTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_department', function (Blueprint $table) {
            $table->dropForeign('sub_department_division_id_foreign');
        });

        Schema::table('sub_department', function (Blueprint $table) {
            $table->dropColumn('division_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_department', function (Blueprint $table) {
            $table->unsignedBigInteger('division_id')->nullable()->default(null);
            $table->foreign('division_id')->references('id')->on('division')->onDelete('set null');
        });
    }
}
