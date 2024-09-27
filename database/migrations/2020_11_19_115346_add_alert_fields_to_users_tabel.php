<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlertFieldsToUsersTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('alert')->default(1);
            $table->tinyInteger('students_alert')->default(1);
            $table->tinyInteger('alert_to_personal')->default(0);
            $table->tinyInteger('contact_to_personal')->default(0);
            $table->tinyInteger('is_subscribed')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alert', 'students_alert', 'alert_to_personal', 'contact_to_personal', 'is_subscribed']);
        });
    }
}
