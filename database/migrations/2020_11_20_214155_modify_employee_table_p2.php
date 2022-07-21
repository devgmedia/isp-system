<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyEmployeeTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropForeign('employee_province_id_foreign');
            $table->dropForeign('employee_district_id_foreign');
            $table->dropForeign('employee_sub_district_id_foreign');
            $table->dropForeign('employee_village_id_foreign');
        });

        Schema::table('employee', function (Blueprint $table) {
            $table->dropColumn('province_id');
            $table->dropColumn('district_id');
            $table->dropColumn('sub_district_id');
            $table->dropColumn('village_id');
            $table->dropColumn('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->unsignedBigInteger('province_id')->nullable()->default(null);
            $table->unsignedBigInteger('district_id')->nullable()->default(null);
            $table->unsignedBigInteger('sub_district_id')->nullable()->default(null);
            $table->unsignedBigInteger('village_id')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
        });

        Schema::table('employee', function (Blueprint $table) {
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('village_id')->references('id')->on('village')->onDelete('set null');
        });
    }
}
