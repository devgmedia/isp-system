<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySupplierTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->dropColumn('created_date');
            $table->dropColumn('verified_date');

            $table->boolean('verified')->nullable()->default(false);
            $table->datetime('verified_at')->nullable()->default(null);
        });

        Schema::table('supplier', function (Blueprint $table) {
            $table->dropForeign('supplier_created_by_foreign');
            $table->dropForeign('supplier_verified_by_foreign');
        });

        Schema::table('supplier', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('verified_by')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->date('created_date')->nullable()->default(null);
            $table->date('verified_date')->nullable()->default(null);

            $table->dropColumn('verified');
            $table->dropColumn('verified_at');
        });

        Schema::table('supplier', function (Blueprint $table) {
            $table->dropForeign('supplier_created_by_foreign');
            $table->dropForeign('supplier_verified_by_foreign');
        });

        Schema::table('supplier', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('user')->onDelete('set null');
            $table->foreign('verified_by')->references('id')->on('user')->onDelete('set null');
        });
    }
}
