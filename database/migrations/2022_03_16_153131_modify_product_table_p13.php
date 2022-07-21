<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductTableP13 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->boolean('enable_ignore_tax')->nullable()->default(false);
            $table->boolean('enable_ignore_prorated')->nullable()->default(false);
            $table->boolean('enable_postpaid')->nullable()->default(false);
            $table->boolean('enable_hybrid')->nullable()->default(false);
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
