<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhookParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_params', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('webhook_url_id')->unsigned();
            $table->string('name', 100)->nullable(false);
            $table->string('value', 500)->nullable(false);
            $table->timestamps();
            $table->softDeletes()->index('index_webhook_params_deleted_at');
        });

        Schema::table('webhook_params', function (Blueprint $table) {
            $table->foreign('webhook_url_id')
                ->references('id')->on('webhook_urls')
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
        Schema::dropIfExists('webhook_params');
    }
}
