<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserQuizesTable extends Migration
{
    /**
     * Run the migratitons.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_quizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('quiz_id');
            $table->boolean('is_completed')->default(false);

            $table->index(['user_id', 'quiz_id']);

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
        Schema::dropIfExists('user_quizes');
    }
}
