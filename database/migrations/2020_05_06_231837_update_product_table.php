<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductTable extends Migration
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
            $table->unsignedBigInteger('bandwidth_type_id')->nullable()->default(null);
            $table->foreign('bandwidth_type_id')->references('id')->on('bandwidth_type')->onDelete('set null');
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
            $table->dropForeign('product_bandwidth_type_id_foreign');
        });

        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('bandwidth_type_id');
        });
    }
}
