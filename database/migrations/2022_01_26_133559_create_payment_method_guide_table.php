<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodGuideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method_guide', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number')->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);
            $table->unsignedBigInteger('payment_method_id')->nullable()->default(NULL);

            $table->timestamps();

            $table->foreign('payment_method_id')->references('id')->on('payment_method')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_method_guide');
    }
}
