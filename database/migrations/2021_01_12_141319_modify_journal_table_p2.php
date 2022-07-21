<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->renameColumn('description', 'name');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->string('name')->nullable()->default(null)->change();
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);

            $table->unique(['name', 'date', 'branch_id']);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
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
            $table->dropUnique('journal_name_date_branch_id_unique');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->renameColumn('name', 'description');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->string('description')->nullable()->default(null)->change();
        });
    }
}
