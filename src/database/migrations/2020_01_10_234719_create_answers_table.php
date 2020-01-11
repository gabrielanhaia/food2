<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAnswersTable
 *
 * Migration responsible for creating table "answers"
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned()->nullable(false);
            $table->text('valid_value', 256)->nullable(true);
            $table->timestamps();
            $table->softDeletes()->index('index_answers_deleted_at');
        });

        Schema::table('answers', function (Blueprint $table) {
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
        Schema::dropIfExists('answers');
    }
}
