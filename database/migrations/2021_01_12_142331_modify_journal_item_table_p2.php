<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalItemTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_item', function (Blueprint $table) {
            $table->string('name')->nullable()->default(null);

            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_item', function (Blueprint $table) {
            $table->dropUnique('journal_item_name_unique');
        });

        Schema::table('journal_item', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}
