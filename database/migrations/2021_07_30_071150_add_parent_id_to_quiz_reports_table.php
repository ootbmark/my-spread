<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentIdToQuizReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('group_id');

            $table->foreign('parent_id')->on('quiz_reports')->references('id')->onDelete('cascade');
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
            $table->dropForeign('quiz_reports_parent_id_foreign');

            $table->dropColumn('parent_id');
        });
    }
}
