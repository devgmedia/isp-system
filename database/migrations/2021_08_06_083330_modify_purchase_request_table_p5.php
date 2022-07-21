<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseRequestTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->boolean('division_approval_request')->default(false)->after('created_date');
            $table->unsignedBigInteger('division_approved_by')->nullable()->default(NULL);
            $table->string('division_approved_name')->nullable()->default(NULL);
            $table->date('division_approved_date')->nullable()->default(NULL);

            $table->foreign('division_approved_by')->references('id')->on('division')->onDelete('set null');
            
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
                'division_approval_request', 
                'division_approved_by',
                'division_approved_name',
                'division_approved_date',
            ]);
        });
    }
}
