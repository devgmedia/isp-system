<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRouterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_router', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('host');
            $table->string('user');
            $table->string('pass');
            $table->unsignedSmallInteger('port');
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['host', 'user', 'product_id']);
            $table->foreign('product_id')->references('id')->on('product')->onDelete('set null');
        });

        DB::table('product')->get()->each(function ($product) {
            DB::table('product_router')->insert([
                'host' => $product->router_host,
                'user' => $product->router_user,
                'pass' => $product->router_pass,
                'port' => $product->router_port,
                'product_id' => $product->id,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_router');
    }
}
