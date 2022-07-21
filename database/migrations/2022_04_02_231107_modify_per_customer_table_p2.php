<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPerCustomerTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('pre_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');

            $table->string('device_token')->nullable()->default(null);

            $table->boolean('is_isp')->nullable()->default(false);
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->foreign('brand_id')->references('id')->on('product_brand')->onDelete('set null');
            $table->string('contact_person')->nullable()->default(null);

            $table->string('json_products')->nullable()->default(null);
            $table->string('json_agents')->nullable()->default(null);

            $table->boolean('public_facility')->nullable()->default(false);

            $table->boolean('price_include_tax')->nullable()->default(false);
            $table->string('json_product_tags')->nullable()->default(null);
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
