<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->integer('packs_quantity')->nullable()->default(null);
            $table->unsignedBigInteger('packs_unit_id')->nullable()->default(null);

            $table->foreign('packs_unit_id')->references('id')->on('item_packs_unit')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->dropForeign('item_packs_unit_id_foreign');
        });

        Schema::table('item', function (Blueprint $table) {
            $table->dropColumn('packs_quantity');
            $table->dropColumn('packs_unit_id');
        });
    }
}
