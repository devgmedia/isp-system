<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertCustomerTableP10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropUnique('customer_uuid_unique');
        });

        Schema::table('customer', function (Blueprint $table) {
            $table->string('uuid')->unique()->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropUnique('customer_uuid_unique');
        });

        Schema::table('customer', function (Blueprint $table) {
            $table->string('uuid')->unique()->default(null)->change();
        });
    }
}
