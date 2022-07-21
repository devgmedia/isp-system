<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyHeighbourhoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('neighbourhood', function (Blueprint $table) {
            $table->unsignedBigInteger('province_id')->nullable()->default(null)->before('hamlet_id');
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');

            $table->unsignedBigInteger('district_id')->nullable()->default(null)->before('hamlet_id');
            $table->foreign('district_id')->references('id')->on('district')->onDelete('set null');

            $table->unsignedBigInteger('sub_district_id')->nullable()->default(null)->before('hamlet_id');
            $table->foreign('sub_district_id')->references('id')->on('sub_district')->onDelete('set null');

            $table->unsignedBigInteger('village_id')->nullable()->default(null)->before('hamlet_id');
            $table->foreign('village_id')->references('id')->on('village')->onDelete('set null');
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
