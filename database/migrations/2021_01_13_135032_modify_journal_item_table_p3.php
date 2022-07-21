<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalItemTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('journal_item', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_card_id')->nullable()->default(null);

            $table->foreign('chart_of_account_card_id')->references('id')->on('chart_of_account_card')->onDelete('set null');
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
            $table->dropColumn('chart_of_account_card_id');
        });
    }
}
