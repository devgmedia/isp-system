<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRegionalTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('regional', function (Blueprint $table) {
            $table->boolean('spm_finance_is_active')->nullable()->default(null);
            $table->string('spm_finance_pic')->nullable()->default(null);
            $table->string('spm_finance_pic_email')->nullable()->default(null);

            $table->boolean('spm_general_manager_is_active')->nullable()->default(null);
            $table->string('spm_general_manager_pic')->nullable()->default(null);
            $table->string('spm_general_manager_pic_email')->nullable()->default(null);

            $table->boolean('spm_director_is_active')->nullable()->default(null);
            $table->string('spm_director_pic')->nullable()->default(null);
            $table->string('spm_director_pic_email')->nullable()->default(null);
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
