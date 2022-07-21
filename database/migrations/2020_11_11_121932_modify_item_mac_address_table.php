<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemMacAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_mac_address', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable()->default(null);
            $table->string('name')->unique()->nullable()->default(null);     
            
            $table->foreign('item_id')->references('id')->on('item')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_mac_address', function (Blueprint $table) {
            $table->dropForeign('item_mac_address_item_id_foreign');
        });

        Schema::table('item_mac_address', function (Blueprint $table) {
            $table->dropColumn('item_id');
            $table->dropColumn('name');
        });
    }
}
