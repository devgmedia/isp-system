<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpmTableP9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('spm', function (Blueprint $table) {
            $table->boolean('general_manager_approved')->nullable()->default(null);
            $table->unsignedBigInteger('general_manager_approved_by')->nullable()->default(null);
            $table->datetime('general_manager_approved_at')->nullable()->default(null);
            $table->string('general_manager_approval_note')->nullable()->default(null);

            $table->foreign('general_manager_approved_by')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
