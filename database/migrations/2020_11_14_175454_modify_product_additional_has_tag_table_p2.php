<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductAdditionalHasTagTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_additional_has_tag', function (Blueprint $table) {
            $table->unique(['product_additional_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_additional_has_tag', function (Blueprint $table) {
            $table->dropUnique('product_additional_has_tag_product_additional_id_tag_id_unique');
        });
    }
}
