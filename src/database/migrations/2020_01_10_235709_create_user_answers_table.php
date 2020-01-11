<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserAnswersTable
 *
 * Migration responsible for creating table "user_answers"
 */
class CreateUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answers', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->bigInteger('question_id')->unsigned()->nullable(false);
            $table->bigInteger('answer_id')->unsigned()->nullable(false);
            $table->text('text_answer')->nullable(true);
            $table->date('date_answer')->nullable(true);
            $table->float('number_answer')->nullable(true);
            $table->timestamps();
            $table->softDeletes()->index('index_user_answers_deleted_at');

            $table->primary(['user_id', 'question_id', 'answer_id']);
        });

        Schema::table('user_answers', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('answer_id')
                ->references('id')->on('answers')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_answers');
    }
}
