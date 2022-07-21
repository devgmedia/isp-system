<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalHasTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('journal_has_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('journal_id')->nullable()->default(null);
            $table->unsignedBigInteger('tag_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['journal_id', 'tag_id']);
            $table->foreign('journal_id')->references('id')->on('journal')->onDelete('set null');
            $table->foreign('tag_id')->references('id')->on('journal_tag')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_has_tag');
    }
}
