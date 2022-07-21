<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSupplierTable extends Migration
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
            $table->dropForeign(['created']);
            $table->dropForeign(['director_of_operations']);

            $table->renameColumn('created', 'created_by');
            $table->renameColumn('director_of_operations', 'verified_by');
            $table->renameColumn('director_of_operations_verified_date', 'verified_date');

            $table->foreign('created_by')->references('id')->on('user')->onDelete('set null');
            $table->foreign('verified_by')->references('id')->on('user')->onDelete('set null');
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
            $table->dropForeign(['created_by']);
            $table->dropForeign(['verified_by']);

            $table->renameColumn('created_by', 'created');
            $table->renameColumn('verified_by', 'director_of_operations');
            $table->renameColumn('verified_date', 'director_of_operations_verified_date');

            $table->foreign('created')->references('id')->on('user')->onDelete('set null');
            $table->foreign('director_of_operations')->references('id')->on('user')->onDelete('set null');
        });
    }
}
