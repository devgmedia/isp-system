<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductAdditionalDiscountTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('product_additional_discount', function (Blueprint $table) {
            $table->unique(['product_additional_id', 'discount_id'], 'pro_add_dis_pro_add_id_dis_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_additional_discount', function (Blueprint $table) {
            $table->dropUnique('pro_add_dis_pro_add_id_dis_id_unique');
        });
    }
}
