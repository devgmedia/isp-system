<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySupplierPicPhoneNumberTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('supplier_pic_phone_number', function (Blueprint $table) {
            $table->unique(['supplier_pic_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier_pic_phone_number', function (Blueprint $table) {
            $table->dropUnique('supplier_pic_phone_number_supplier_pic_id_number_unique');
        });
    }
}
