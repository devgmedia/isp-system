<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseRequestTableP5 extends Migration
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
            // drop foreign before rename
            $table->dropForeign(['finance_manager']);
            $table->dropForeign(['director_of_operations']);

            // renaming column
            // make sure using doctrine/dbal on composer.json
            $table->renameColumn('created', 'created_by');

            $table->renameColumn('finance_manager', 'finance_approved_by');
            $table->renameColumn('finance_manager_name', 'finance_approved_name');
            $table->renameColumn('finance_manager_approved_date', 'finance_approved_date');

            $table->renameColumn('director_of_operations', 'director_approved_by');
            $table->renameColumn('director_of_operations_name', 'director_approved_name');
            $table->renameColumn('director_of_operations_approved_date', 'director_approved_date');

            // set new foreign key
            $table->foreign('finance_approved_by')->references('id')->on('user')->onDelete('set null');
            $table->foreign('director_approved_by')->references('id')->on('user')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('user')->onDelete('set null');

            // add new column
            // departement approved
            $table->unsignedBigInteger('department_approved_by')->nullable()->default(null)->after('created_date');
            $table->date('department_approved_date')->nullable()->default(null)->after('department_approved_by');
            $table->string('department_approved_name')->nullable()->default(null)->after('department_approved_date');

            // add new column
            // purchasing approved
            $table->unsignedBigInteger('purchasing_approved_by')->nullable()->default(null)->after('department_approved_name');
            $table->date('purchasing_approved_date')->nullable()->default(null)->after('purchasing_approved_by');
            $table->string('purchasing_approved_name')->nullable()->default(null)->after('purchasing_approved_date');

            // add foreign key column
            $table->foreign('department_approved_by')->references('id')->on('user')->onDelete('set null');
            $table->foreign('purchasing_approved_by')->references('id')->on('user')->onDelete('set null');
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
            // drop foreign before rename
            $table->dropForeign(['finance_approved_by']);
            $table->dropForeign(['director_approved_by']);
            $table->dropForeign(['created_by']);

            // renaming column
            $table->renameColumn('created_by', 'created');

            $table->renameColumn('finance_approved_by', 'finance_manager');
            $table->renameColumn('finance_approved_name', 'finance_manager_name');
            $table->renameColumn('finance_approved_date', 'finance_manager_approved_date');

            $table->renameColumn('director_approved_by', 'director_of_operations');
            $table->renameColumn('director_approved_name', 'director_of_operations_name');
            $table->renameColumn('director_approved_date', 'director_of_operations_approved_date');

            // set new foreign
            $table->foreign('finance_manager')->references('id')->on('user')->onDelete('set null');
            $table->foreign('director_of_operations')->references('id')->on('user')->onDelete('set null');

            // drop foreign before drop column
            $table->dropForeign(['department_approved_by']);
            $table->dropForeign(['purchasing_approved_by']);

            // drop column
            $table->dropColumn([
                'department_approved_by',
                'department_approved_name',
                'department_approved_date',
                'purchasing_approved_by',
                'purchasing_approved_date',
                'purchasing_approved_name',
            ]);
        });
    }
}
