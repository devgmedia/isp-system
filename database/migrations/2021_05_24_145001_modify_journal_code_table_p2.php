<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalCodeTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_code', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');            

            $table->dropUnique('journal_code_name_unique');
            $table->unique(['name', 'branch_id']);
            $table->unique(['name', 'chart_of_account_title_id']);
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
