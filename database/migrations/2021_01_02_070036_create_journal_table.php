<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('journal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->date('date');
            $table->string('description')->nullable()->default(null);
            $table->unsignedBigInteger('type_id')->nullable()->default(null);
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique('uuid');
            $table->unique('ar_invoice_id');
            $table->foreign('type_id')->references('id')->on('journal_type')->onDelete('set null');
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal');
    }
}
