<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentPhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('agent_phone_number', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');

            $table->unsignedBigInteger('agent_id')->nullable()->defalt(null);
            $table->foreign('agent_id')->references('id')->on('agent')->onDelete('set null');

            $table->timestamps();

            $table->unique(['number', 'agent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_phone_number');
    }
}
