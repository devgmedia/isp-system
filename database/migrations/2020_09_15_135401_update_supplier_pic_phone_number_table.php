<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSupplierPICPhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('supplier_pic_phone_number', function (Blueprint $table) {
            $table->dropUnique('supplier_pic_phone_number_number_supplier_id_unique');
            $table->dropForeign('supplier_pic_phone_number_supplier_id_foreign');
        });

        Schema::table('supplier_pic_phone_number', function (Blueprint $table) {
            $table->dropColumn('supplier_id');
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
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);

            $table->unique(['number', 'supplier_id']);
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('set null');
        });
    }
}
