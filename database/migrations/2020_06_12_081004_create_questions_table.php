<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migratitons.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('quiz_id')->index();
            $table->text('title')->nullable();
            $table->enum('type',['multiple', 'dropdown', 'file', 'radio', 'text', 'textarea', 'circling'])->nullable();
            $table->string('file')->nullable();
            $table->enum('file_type', ['image', 'video', 'youtube', 'image_url'])->nullable();
            $table->string('url')->nullable();
            $table->integer('order')->default(1);
            $table->text('question_info')->nullable();
            $table->boolean('is_priority')->nullable();
            $table->boolean('question_required')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
