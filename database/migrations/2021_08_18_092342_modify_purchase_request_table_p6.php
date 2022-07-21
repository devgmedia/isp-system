<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseRequestTableP6 extends Migration
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
            $table->string('division_notes')->nullable()->default(null);
            $table->string('purchasing_notes')->nullable()->default(null);
            $table->string('finance_notes')->nullable()->default(null);
            $table->string('director_notes')->nullable()->default(null);
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
                'division_notes',
                'purchasing_notes',
                'finance_notes',
                'director_notes',
            ]);
        });
    }
}
