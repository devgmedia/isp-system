<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerProductAdditionalTableP8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->boolean('adjusted_quantity')->nullable()->default(false);
            $table->unsignedTinyInteger('quantity')->nullable()->dafault(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->dropColumn([
                'adjusted_quantity',
                'quantity',
            ]);
        });
    }
}
