<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemConditionTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('item_condition', function (Blueprint $table) {
            $table->string('name')->nullable()->default(null)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_condition');
    }
}
