<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOnuTableP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('onu', function (Blueprint $table) {
            $table->dropForeign('onu_olt_id_foreign');

            $table->dropColumn([
                'olt_id',
                'total_port',
                'total_ssid',
                'ip',
            ]);

            $table->unsignedBigInteger('onu_type_id')->nullable()->default(NULL);
            $table->integer('index')->nullable()->default(NULL);
            $table->integer('serial_number')->nullable()->default(NULL);
            $table->integer('distance')->nullable()->default(NULL);
            $table->integer('onu_password')->nullable()->default(NULL);

            $table->foreign('onu_type_id')->references('id')->on('onu_type')->onDelete('set null');


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
