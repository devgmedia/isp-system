<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyReportingCoverageBoqItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_reporting_coverage_boq_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('survey_reporting_coverage_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_product_id')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('brand_name')->nullable()->default(null);
            $table->string('brand_product_name')->nullable()->default(null);
            $table->unsignedSmallInteger('quantity')->nullable()->default(null);
            $table->unsignedBigInteger('unit_id')->nullable()->default(null);
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('survey_reporting_coverage_id', 'sur_rep_cove_id_foreign')->references('id')->on('survey_reporting_coverage')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('item_brand')->onDelete('set null');
            $table->foreign('brand_product_id')->references('id')->on('item_brand_product')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('survey_reporting_coverage_boq_item_unit')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('survey_reporting_coverage_boq_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_reporting_coverage_boq_item');
    }
}
