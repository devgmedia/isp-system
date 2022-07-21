<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOnuTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('onu', function (Blueprint $table) {
            $table->string('cvlan_mgmt')->nullable()->default(NULL);
            $table->string('cvlan_user')->nullable()->default(NULL);
            $table->string('svlan_mgmt')->nullable()->default(NULL);
            $table->string('svlan_user')->nullable()->default(NULL);

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
