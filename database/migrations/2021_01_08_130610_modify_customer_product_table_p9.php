<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->datetime('whatsapp_maintenance_sent_at')->nullable()->default(null);
            $table->datetime('whatsapp_activation_sent_at')->nullable()->default(null);
            $table->datetime('whatsapp_mass_disruption_sent_at')->nullable()->default(null);
            $table->datetime('whatsapp_confirmation_of_mass_disruption_sent_at')->nullable()->default(null);

            $table->datetime('email_maintenance_sent_at')->nullable()->default(null);
            $table->datetime('email_activation_sent_at')->nullable()->default(null);
            $table->datetime('email_mass_disruption_sent_at')->nullable()->default(null);
            $table->datetime('email_confirmation_of_mass_disruption_sent_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropColumn('whatsapp_maintenance_sent_at');
            $table->dropColumn('whatsapp_activation_sent_at');
            $table->dropColumn('whatsapp_mass_disruption_sent_at');
            $table->dropColumn('whatsapp_confirmation_of_mass_disruption_sent_at');

            $table->dropColumn('email_maintenance_sent_at');
            $table->dropColumn('email_activation_sent_at');
            $table->dropColumn('email_mass_disruption_sent_at');
            $table->dropColumn('email_confirmation_of_mass_disruption_sent_at');
        });
    }
}
