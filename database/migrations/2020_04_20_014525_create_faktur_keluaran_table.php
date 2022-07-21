<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakturKeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faktur_keluaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique();
            $table->timestamp('date');
            $table->tinyInteger('masa');
            $table->enum('type', ['normal', 'pengganti', 'batal']);
            $table->integer('dpp');
            $table->integer('ppn');
            $table->integer('pnbp');
            $table->unsignedBigInteger('customer_id')->nullable()->default(NULL);
            $table->string('customer_name')->nullable()->default(NULL);
            $table->string('customer_npwp')->nullable()->default(NULL);
            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->string('branch_name')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
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
        Schema::dropIfExists('faktur_keluaran');
    }
}
