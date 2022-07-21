<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->dropForeign('journal_ar_invoice_id_foreign');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropUnique('journal_ar_invoice_id_unique');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropColumn('ar_invoice_id');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->unsignedBigInteger('code_id')->nullable()->default(null);
            $table->foreign('code_id')->references('id')->on('journal_code')->onDelete('set null');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->nullable()->default(null);
            $table->foreign('menu_id')->references('id')->on('accounting_menu')->onDelete('set null');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->string('reference')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->default(null);
            $table->foreign('project_id')->references('id')->on('journal_project')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
            $table->unique('ar_invoice');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropForeign('journal_code_id_foreign');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropColumn('code_id');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropForeign('accounting_menu_id_foreign');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropColumn('menu_id');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropColumn('reference');
            $table->dropColumn('description');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropForeign('journal_project_id_foreign');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->dropColumn('project_id');
        });
    }
}
