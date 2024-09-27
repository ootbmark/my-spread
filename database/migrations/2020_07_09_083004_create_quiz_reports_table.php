<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizReportsTable extends Migration
{
    /**
     * Run the migratitons.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('quiz_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('group_id')->nullable()->index();
            $table->string('name');
            $table->integer('questions_count')->default(0);
            $table->integer('answers_count')->default(0);
            $table->string('quiz_duration')->nullable();
            $table->string('questions_answers')->nullable();
            $table->enum('status', ['high', 'medium', 'low'])->nullable();
            $table->enum('status_effort', ['high', 'medium', 'low'])->nullable();
            $table->string('action_party')->nullable();
            $table->string('focal_point')->nullable();
            $table->string('target_date')->nullable();
            $table->integer('quiz_status')->nullable();
            $table->integer('report_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_reports');
    }
}
