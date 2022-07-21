<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->unsignedBigInteger('from_ownership_bts_id')->nullable()->default(null)->after('from_ownership_branch_id');

            $table->foreign('from_ownership_bts_id')->references('id')->on('bts')->onDelete('set null');

            $table->unsignedBigInteger('from_location_bts_id')->nullable()->default(null)->after('from_location_branch_id');

            $table->foreign('from_location_bts_id')->references('id')->on('bts')->onDelete('set null');
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
