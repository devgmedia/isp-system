<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPaymentMethodGuideTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('payment_method_guide', function (Blueprint $table) {
            $table->dropForeign('payment_method_guide_payment_method_id_foreign');
            $table->dropColumn('payment_method_id');

            $table->unsignedBigInteger('payment_method_type_id')->nullable()->default(null);
            $table->foreign('payment_method_type_id')->references('id')->on('payment_method_type')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_method_guide', function (Blueprint $table) {
            //
        });
    }
}
