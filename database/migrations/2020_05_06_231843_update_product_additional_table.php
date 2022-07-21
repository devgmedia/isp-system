<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductAdditionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('bandwidth_type_id')->nullable()->default(null);
            $table->foreign('bandwidth_type_id')->references('id')->on('bandwidth_type')->onDelete('set null');
        });

        Schema::table('product_additional', function (Blueprint $table) {
            $table->dropUnique('product_additional_sid_unique');
        });

        Schema::table('product_additional', function (Blueprint $table) {
            $table->dropColumn('sid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_additional', function (Blueprint $table) {
            $table->dropForeign('product_additional_bandwidth_type_id_foreign');
        });

        Schema::table('product_additional', function (Blueprint $table) {
            $table->dropColumn('bandwidth_type_id');
        });

        Schema::table('product_additional', function (Blueprint $table) {
            $table->string('sid')->unique()->nullable()->default(NULL);
        });
    }
}
