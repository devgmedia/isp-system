<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseRequestTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->string('number')->nullable(false)->change();
            $table->dropColumn('department_approval_request');
            $table->dropColumn('purchasing_approval_request');
            $table->dropColumn('finance_approval_request');
            $table->dropColumn('director_approval_request');
            $table->float('total', 15, 2)->nullable(false)->change();
            $table->unsignedBigInteger('department_id')->nullable()->default(null);
            $table->unsignedBigInteger('division_id')->nullable()->default(null);
            $table->string('created_name')->nullable()->default(null);
            $table->string('approval_token')->nullable()->default(null);
            $table->date('department_approval_request_date')->nullable()->default(null);
            $table->date('purchasing_approval_request_date')->nullable()->default(null);
            $table->date('finance_approval_request_date')->nullable()->default(null);
            $table->date('director_approval_request_date')->nullable()->default(null);

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
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->dropForeign('purchase_request_department_id_foreign');
            $table->dropForeign('purchase_request_division_id_foreign');
        });

        Schema::table('purchase_request', function (Blueprint $table) {
            $table->string('number')->nullable()->default(null)->change();
            $table->boolean('department_approval_request')->nullable()->default(false);
            $table->boolean('purchasing_approval_request')->nullable()->default(false);
            $table->boolean('finance_approval_request')->nullable()->default(false);
            $table->boolean('director_approval_request')->nullable()->default(false);
            $table->unsignedInteger('total')->nullable()->default(null)->change();
            $table->dropColumn('department_id');
            $table->dropColumn('division_id');
            $table->dropColumn('created_name');
            $table->dropColumn('approval_token');
            $table->dropColumn('department_approval_request_date');
            $table->dropColumn('purchasing_approval_request_date');
            $table->dropColumn('finance_approval_request_date');
            $table->dropColumn('director_approval_request_date');
        });
    }
}
