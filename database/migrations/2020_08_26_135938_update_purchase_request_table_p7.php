<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseRequestTableP7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_department_id')->nullable()->default(null)->after('branch_id');

            $table->foreign('sub_department_id')->references('id')->on('sub_department')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->dropForeign(['sub_department_id']);
            
            $table->dropColumn([
                'sub_department_id',
            ]);
        });
    }
}
