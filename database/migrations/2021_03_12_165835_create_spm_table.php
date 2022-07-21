<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('name');
            $table->unsignedBigInteger('fixcost_category_id')->nullable()->default(null);
            $table->boolean('urgent')->nullable()->default(false);
            $table->unsignedBigInteger('ap_invoice_id')->nullable()->default(null);
            $table->date('due_date')->nullable()->default(null);
            $table->unsignedBigInteger('cash_bank_id')->nullable()->default(null);
            $table->unsignedBigInteger('receiver_id')->nullable()->default(null);
            $table->string('number');
            $table->unsignedBigInteger('division_category_id')->nullable()->default(null);
            $table->unsignedBigInteger('payment_method_id')->nullable()->default(null);
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);

            $table->string('approval_id')->nullable()->default(null);

            $table->boolean('branch_manager_approved')->nullable()->default(false);
            $table->unsignedBigInteger('branch_manager_approved_by')->nullable()->default(null);
            $table->datetime('branch_manager_approved_at')->nullable()->default(null);

            $table->boolean('finance_approved')->nullable()->default(false);
            $table->unsignedBigInteger('finance_approved_by')->nullable()->default(null);
            $table->datetime('finance_approved_at')->nullable()->default(null);

            $table->boolean('director_approved')->nullable()->default(false);
            $table->unsignedBigInteger('director_approved_by')->nullable()->default(null);
            $table->datetime('director_approved_at')->nullable()->default(null);

            $table->boolean('marked')->nullable()->default(false);
            $table->datetime('marked_at')->nullable()->default(null);

            $table->boolean('authorized')->nullable()->default(false);
            $table->datetime('authorized_at')->nullable()->default(null);

            $table->boolean('cancel')->nullable()->default(false);
            $table->datetime('cancel_at')->nullable()->default(null);

            $table->string('note')->nullable()->default(null);

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique('uuid');
            $table->unique('number');

            $table->foreign('fixcost_category_id')->references('id')->on('spm_fixcost_category')->onDelete('set null');
            $table->foreign('ap_invoice_id')->references('id')->on('ap_invoice')->onDelete('set null');
            $table->foreign('cash_bank_id')->references('id')->on('cash_bank')->onDelete('set null');
            $table->foreign('receiver_id')->references('id')->on('spm_receiver')->onDelete('set null');
            $table->foreign('division_category_id')->references('id')->on('spm_division_category')->onDelete('set null');
            $table->foreign('payment_method_id')->references('id')->on('spm_payment_method')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('employee')->onDelete('set null');

            $table->foreign('branch_manager_approved_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('finance_approved_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('director_approved_by')->references('id')->on('employee')->onDelete('set null');

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spm');
    }
}
