<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreCustomerTableP9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_customer', function (Blueprint $table) {
            $table->integer('verification_attempt')->nullable()->default(0);
            $table->boolean('verification_contact')->nullable()->default(null);
            $table->boolean('verification_contact_sent')->nullable()->default(null);
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
