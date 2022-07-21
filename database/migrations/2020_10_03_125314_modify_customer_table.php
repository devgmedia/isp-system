<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->string('email')->nullable()->default(null)->change();
            $table->string('alias_name')->nullable()->default(null);
            $table->string('identity_card_file')->nullable()->default(null);
            $table->string('house_photo')->nullable()->default(null);
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
            $table->string('email')->unique()->nullable(false)->change();
            $table->dropColumn('alias_name');
            $table->dropColumn('identity_card_file');
            $table->dropColumn('house_photo');
        });
    }
}
