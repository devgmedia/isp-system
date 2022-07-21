<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);

            $table->foreign('brand_id')->references('id')->on('product_brand')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign('product_brand_id_foreign');
        });

        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('brand_id');
        });
    }
}
