<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhookUrls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_urls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('weebhook_id')->unsigned();
            $table->string('url')->nullable(false);
            $table->boolean('enabled');
            $table->timestamps();
            $table->softDeletes()->index('index_webhook_urls_deleted_at');
        });

        Schema::table('webhook_urls', function (Blueprint $table) {
            $table->foreign('webhook_id')
                ->references('id')->on('webhooks')
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
        Schema::dropIfExists('webhook_urls');
    }
}
