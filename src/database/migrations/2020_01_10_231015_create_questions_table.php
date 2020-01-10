<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateQuestionsTable
 *
 * Migration responsible for creating the table "questions"
 *
 * @author Gabriel Anhaia <gabriel@stargrid.pro>
 */
class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('form_id')->unsigned()->nullable(false);
            $table->text('description')->nullable(false);
            $table->boolean('mandoraty')->nullable(false);
            $table->enum('type', ['number', 'text', 'date', 'radio', 'dropdown'])->nullable(false);
            $table->timestamps();
            $table->softDeletes()->index('index_questions_deleted_at');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('form_id')
                ->references('id')->on('forms')
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
        Schema::dropIfExists('questions');
    }
}
