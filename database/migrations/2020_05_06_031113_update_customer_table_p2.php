<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            DB::statement('ALTER TABLE customer MODIFY cid VARCHAR (255) COLLATE utf8_unicode_ci NOT NULL');
            DB::statement('ALTER TABLE customer MODIFY email VARCHAR (255) COLLATE utf8_unicode_ci NOT NULL');
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
            DB::statement('ALTER TABLE customer MODIFY cid VARCHAR (255) COLLATE utf8_unicode_ci NULL DEFAULT NULL');
            DB::statement('ALTER TABLE customer MODIFY email VARCHAR (255) COLLATE utf8_unicode_ci NULL DEFAULT NULL');
        });
    }
}
