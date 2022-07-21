<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompanyTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('company');

            if (array_key_exists('company_alpha_3_code_unique', $indexesFound)) {
                $table->dropUnique('company_alpha_3_code_unique');
            }
        });

        Schema::table('company', function (Blueprint $table) {
            if (Schema::hasColumn('company', 'alpha_3_code')) {
                $table->string('alpha_3_code')->nullabe()->default(null)->change();
            } else {
                $table->string('alpha_3_code')->nullabe()->default(null);
            }
        });

        Schema::table('company', function (Blueprint $table) {
            $table->unique('alpha_3_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('company');

            if (array_key_exists('company_alpha_3_code_unique', $indexesFound)) {
                $table->dropUnique('company_alpha_3_code_unique');
            }
        });

        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn('alpha_3_code');
        });
    }
}
