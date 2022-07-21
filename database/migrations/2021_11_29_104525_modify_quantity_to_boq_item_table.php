<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyQuantityToBoqItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boq_item', function (Blueprint $table) {
            $table->string('quantity')->nullable()->default(NULL);
            $table->unsignedBigInteger('unit_id')->nullable()->default(NULL);

            $table->foreign('unit_id')->references('id')->on('boq_unit')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boq_item', function (Blueprint $table) {
            //
        });
    }
}
