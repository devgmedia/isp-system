<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMidtransNotificationTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('midtrans_notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id')->nullable()->default(null);
            $table->string('transaction_status')->nullable()->default(null);
            $table->string('payment_type')->nullable()->default(null);
            $table->string('fraud_status')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('midtrans_notification');
    }
}
