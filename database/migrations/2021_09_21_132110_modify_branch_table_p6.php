<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBranchTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch', function (Blueprint $table) {
            $table->string('pr_purchasing_approval_email')->nullable()->default(null);
            $table->string('pr_purchasing_approval_name')->nullable()->default(null);

            $table->string('pr_finance_approval_email')->nullable()->default(null);
            $table->string('pr_finance_approval_name')->nullable()->default(null);
            
            $table->string('pr_general_manager_approval_email')->nullable()->default(null);
            $table->string('pr_general_manager_approval_name')->nullable()->default(null);

            $table->string('pr_director_approval_email')->nullable()->default(null);
            $table->string('pr_director_approval_name')->nullable()->default(null);

            $table->string('po_finance_approval_email')->nullable()->default(null);
            $table->string('po_finance_approval_name')->nullable()->default(null);

            $table->string('po_general_manager_approval_email')->nullable()->default(null);
            $table->string('po_general_manager_approval_name')->nullable()->default(null);

            $table->string('po_director_approval_email')->nullable()->default(null);
            $table->string('po_director_approval_name')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch', function (Blueprint $table) {
            $table->dropColumn('pr_purchasing_approval_email');
            $table->dropColumn('pr_purchasing_approval_name');

            $table->dropColumn('pr_finance_approval_email');
            $table->dropColumn('pr_finance_approval_name');
            
            $table->dropColumn('pr_general_manager_approval_email');
            $table->dropColumn('pr_genaral_manager_approval_name');

            $table->dropColumn('pr_director_approval_email');
            $table->dropColumn('pr_director_approval_name');

            $table->dropColumn('po_finance_approval_email');
            $table->dropColumn('po_finance_approval_name');

            $table->dropColumn('po_general_manager_approval_email');
            $table->dropColumn('po_genaral_manager_approval_name');

            $table->dropColumn('po_director_approval_email');
            $table->dropColumn('po_director_approval_name');
        });
    }
}
