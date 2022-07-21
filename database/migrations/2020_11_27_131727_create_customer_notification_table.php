<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('message');
            $table->date('date');
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->dafault(NULL);
            $table->unsignedBigInteger('customer_id')->nullable()->dafault(NULL);
            $table->timestamp('read_at')->nullable()->dafault(NULL);
            $table->timestamps();

            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_notification');
    }
}
