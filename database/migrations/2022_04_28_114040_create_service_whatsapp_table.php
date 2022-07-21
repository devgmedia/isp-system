<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceWhatsappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_whatsapp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();

            $table->unsignedBigInteger('customer_product_id')->nullable()->default(null);
            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');

            $table->string('template_name');
            $table->string('name');

            $table->string('message_id')->nullable()->default(null);
            $table->string('message_status')->nullable()->default(null);

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
        //
    }
}
