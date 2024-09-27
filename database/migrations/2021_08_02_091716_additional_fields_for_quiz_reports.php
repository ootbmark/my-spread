<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdditionalFieldsForQuizReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quizes', function (Blueprint $table) {
            $table->string('verification_text_1')->default('Detailed Drilling Instructions (SID)')->after('class');
            $table->string('verification_text_2')->default('Detailed Ops Procedure')->after('verification_text_1');
            $table->string('verification_text_3')->default('Look Ahead / Logistics')->after('verification_text_2');
            $table->string('verification_text_4')->default('JSA')->after('verification_text_3');
            $table->string('verification_text_5')->default('GrupoR RSP')->after('verification_text_4');
        });

        Schema::table('quiz_reports', function (Blueprint $table) {
            $table->enum('priority', ['high', 'medium', 'low'])->nullable()->after('status_effort');
            $table->string('business_partner')->nullable()->after('target_date');

            $table->boolean('is_verification_1')->default(false)->after('business_partner');
            $table->boolean('is_verification_2')->default(false)->after('is_verification_1');
            $table->boolean('is_verification_3')->default(false)->after('is_verification_2');
            $table->boolean('is_verification_4')->default(false)->after('is_verification_3');
            $table->boolean('is_verification_5')->default(false)->after('is_verification_4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_reports', function (Blueprint $table) {
            $table->dropColumn('priority');
            $table->dropColumn('business_partner');

            $table->dropColumn('is_verification_1');
            $table->dropColumn('is_verification_2');
            $table->dropColumn('is_verification_3');
            $table->dropColumn('is_verification_4');
            $table->dropColumn('is_verification_5');
        });

        Schema::table('quizes', function (Blueprint $table) {
            $table->dropColumn('verification_text_1');
            $table->dropColumn('verification_text_2');
            $table->dropColumn('verification_text_3');
            $table->dropColumn('verification_text_4');
            $table->dropColumn('verification_text_5');
        });
    }
}
