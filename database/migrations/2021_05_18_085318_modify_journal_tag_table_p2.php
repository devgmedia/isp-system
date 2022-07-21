<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalTagTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('journal_tag', function (Blueprint $table) {
            $table->dropUnique('journal_tag_name_unique');
        });

        Schema::table('journal_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
        });

        Schema::table('journal_tag', function (Blueprint $table) {
            $table->unique(['name', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_tag', function (Blueprint $table) {
            $table->dropUnique('journal_tag_name_branch_id_unique');
        });

        Schema::table('journal_tag', function (Blueprint $table) {
            $table->dropForeign('journal_tag_branch_id_foreign');
        });

        Schema::table('journal_tag', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });

        Schema::table('journal_tag', function (Blueprint $table) {
            $table->unique('name');
        });
    }
}
