<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFormsTable
 *
 * Migration responsible for creating the table "form"
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->string('name', 256)->unique();
            $table->text('description');
            $table->text('introduction');
            $table->dateTime('start_publish');
            $table->dateTime('end_publish');
            $table->timestamps();
            $table->softDeletes()->index('index_forms_deleted_at');
        });

        Schema::table('forms', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('forms');
    }
}
