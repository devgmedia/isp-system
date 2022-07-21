<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreCustomerTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('pre_customer', function (Blueprint $table) {
            $table->string('cid')->unique()->nullable()->default(null);
            $table->string('pic')->nullable()->default(null);
            $table->boolean('cancel')->nullable()->default(false);
            $table->datetime('cancel_at')->nullable()->default(null);
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
