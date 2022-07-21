<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('chart_of_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable()->default(null);
            $table->string('name');
            $table->unsignedBigInteger('equation')->nullable()->default(null);
            $table->unsignedBigInteger('parent')->nullable()->default(null);
            $table->date('apply_start_date');
            $table->date('apply_end_date');
            $table->boolean('hide_in_report');
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['code', 'name', 'apply_start_date', 'apply_end_date', 'branch_id'], 'cha_of_acc_cod_nam_app_sta_dat_app_end_dat_bra_id_unique');

            $table->foreign('equation')->references('id')->on('accounting_equation')->onDelete('set null');
            $table->foreign('parent')->references('id')->on('chart_of_account')->onDelete('set null');
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
        Schema::dropIfExists('chart_of_account');
    }
}
