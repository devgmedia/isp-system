<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderTableP10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order', function (Blueprint $table) { 
            $table->unsignedBigInteger('accounting_division_category_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('journal_project_id')->nullable()->default(NULL); 
            
            $table->foreign('accounting_division_category_id')->references('id')->on('accounting_division_category')->onDelete('set null');
            $table->foreign('journal_project_id')->references('id')->on('journal_project')->onDelete('set null');
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
