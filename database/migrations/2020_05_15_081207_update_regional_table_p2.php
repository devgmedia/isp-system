<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRegionalTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regional', function (Blueprint $table) {
            $table->string('address')->nullable()->default(false);
            $table->string('postal_code')->nullable()->default(false);
            $table->string('phone_number')->nullable()->default(false);
            $table->string('fax')->nullable()->default(false);
            $table->string('email')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regional', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'postal_code',
                'phone_number',
                'fax',
                'email',
            ]);
        });
    }
}
