<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBoqTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boq', function (Blueprint $table) {
            // revision
            $table->unsignedBigInteger('marketing_revision_by')->nullable()->default(null);
            $table->date('marketing_revision_date')->nullable()->default(null);
            $table->string('marketing_revision_name')->nullable()->default(null);

            $table->unsignedBigInteger('finance_revision_by')->nullable()->default(null);
            $table->date('finance_revision_date')->nullable()->default(null);
            $table->string('finance_revision_name')->nullable()->default(null);

            $table->unsignedBigInteger('director_revision_by')->nullable()->default(null);
            $table->date('director_revision_date')->nullable()->default(null);
            $table->string('director_revision_name')->nullable()->default(null);

            // revision
            $table->foreign('marketing_revision_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('finance_revision_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('director_revision_by')->references('id')->on('employee')->onDelete('set null');

            //deny
            $table->unsignedBigInteger('marketing_deny_by')->nullable()->default(null);
            $table->date('marketing_deny_date')->nullable()->default(null);
            $table->string('marketing_deny_name')->nullable()->default(null);

            $table->unsignedBigInteger('finance_deny_by')->nullable()->default(null);
            $table->date('finance_deny_date')->nullable()->default(null);
            $table->string('finance_deny_name')->nullable()->default(null);

            $table->unsignedBigInteger('director_deny_by')->nullable()->default(null);
            $table->date('director_deny_date')->nullable()->default(null);
            $table->string('director_deny_name')->nullable()->default(null);

            //deny
            $table->foreign('marketing_deny_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('finance_deny_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('director_deny_by')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boq');
    }
}
