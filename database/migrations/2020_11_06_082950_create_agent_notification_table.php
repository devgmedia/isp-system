<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('agent_notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('message');
            $table->timestamp('date');
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->dafault(null);
            $table->unsignedBigInteger('agent_id')->nullable()->dafault(null);
            $table->string('level'); //low, medium, high
            $table->timestamp('read_at')->nullable()->dafault(null);
            $table->timestamps();

            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
            $table->foreign('agent_id')->references('id')->on('agent')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_notification');
    }
}
