<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->boolean('posted')->nullable()->default(false);
            $table->datetime('posted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->dropColumn('posted');
            $table->dropColumn('posted_at');
        });
    }
}
