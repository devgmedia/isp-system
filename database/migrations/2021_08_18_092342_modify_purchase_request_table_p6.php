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
    public function up()
    {
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->string('division_notes')->nullable()->default(NULL);
            $table->string('purchasing_notes')->nullable()->default(NULL);
            $table->string('finance_notes')->nullable()->default(NULL);
            $table->string('director_notes')->nullable()->default(NULL);
 
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
