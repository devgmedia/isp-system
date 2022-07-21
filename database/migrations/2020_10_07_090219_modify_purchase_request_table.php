<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseRequestTable extends Migration
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
            $table->boolean('department_approval_request')->default(false)->after('created_date');
            $table->boolean('purchasing_approval_request')->default(false)->after('department_approved_name');
            $table->boolean('finance_approval_request')->default(false)->after('purchasing_approved_date');
            $table->boolean('director_approval_request')->default(false)->after('finance_approved_date');
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
            $table->dropColumn([
                'department_approval_request',
                'purchasing_approval_request',
                'finance_approval_request',
                'director_approval_request',
            ]);
        });
    }
}
