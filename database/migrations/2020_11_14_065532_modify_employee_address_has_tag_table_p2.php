<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyEmployeeAddressHasTagTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_address_has_tag', function (Blueprint $table) {
            $table->unique(['address_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_address_has_tag', function (Blueprint $table) {
            $table->dropUnique('employee_address_has_tag_address_id_tag_id_unique');
        });
    }
}
