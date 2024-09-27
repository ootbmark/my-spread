<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceIdToThreadsAndRepliesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->unsignedBigInteger('source_id')->nullable()->after('status');

            $table->foreign('source_id', 'threads_source_id_foreign')->on('threads')->references('id')->onDelete('cascade');
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->unsignedBigInteger('source_id')->nullable()->after('status');

            $table->foreign('source_id', 'replies_source_id_foreign')->on('replies')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropForeign('threads_source_id_foreign');

            $table->dropColumn('source_id');
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->dropForeign('replies_source_id_foreign');

            $table->dropColumn('source_id');
        });
    }
}
