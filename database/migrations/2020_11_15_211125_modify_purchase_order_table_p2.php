<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order', function (Blueprint $table) {
            $table->string('number')->nullable(false)->change();
            $table->string('about')->nullable()->default(null)->change();
            $table->string('approval_token')->nullable()->default(null);
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);
            $table->unsignedBigInteger('sub_department_id')->nullable()->default(null);
            $table->unsignedBigInteger('department_id')->nullable()->default(null);
            $table->unsignedBigInteger('division_id')->nullable()->default(null);
            $table->date('finance_approval_request_date')->nullable()->default(null);
            $table->date('director_approval_request_date')->nullable()->default(null);

            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('set null');
            $table->foreign('sub_department_id')->references('id')->on('sub_department')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('department')->onDelete('set null');
            $table->foreign('division_id')->references('id')->on('division')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order', function (Blueprint $table) {
            $table->dropForeign('purchase_order_supplier_id_foreign');
            $table->dropForeign('purchase_order_sub_department_id_foreign');
            $table->dropForeign('purchase_order_department_id_foreign');
            $table->dropForeign('purchase_order_division_id_foreign');
        });

        Schema::table('purchase_order', function (Blueprint $table) {
            $table->string('number')->nullable()->default(null)->change();
            $table->string('about')->nullable(false)->change();
            $table->dropColumn('approval_token');
            $table->dropColumn('supplier_id');
            $table->dropColumn('sub_department_id');
            $table->dropColumn('department_id');
            $table->dropColumn('division_id');
            $table->dropColumn('finance_approval_request_date');
            $table->dropColumn('director_approval_request_date');
        });
    }
}
