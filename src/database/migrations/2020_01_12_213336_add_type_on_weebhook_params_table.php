<?php

use App\Service\Webhooks\WebhookExtraDataEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddTypeOnWeebhookParamsTable
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class AddTypeOnWeebhookParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webhook_params', function (Blueprint $table) {
            $table->enum('type', [
                WebhookExtraDataEnum::GET_PARAM,
                WebhookExtraDataEnum::POST_HEADER,
                WebhookExtraDataEnum::POST_BODY,
            ])->nullable(false)
                ->after('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webhook_params', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
