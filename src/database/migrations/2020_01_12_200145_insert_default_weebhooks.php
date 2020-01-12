<?php

use App\Models\Webhook;
use App\Service\Webhooks\Scopes\Forms\FormActionEnum;
use App\Service\Webhooks\Scopes\ScopeEnum;
use Illuminate\Database\Migrations\Migration;

/**
 * Class InsertDefaultWeebhooks
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class InsertDefaultWeebhooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Webhook::create([
            'scope' => ScopeEnum::SCOPE_FORM,
            'action' => FormActionEnum::CREATE_FORM
        ]);

        Webhook::create([
            'scope' => ScopeEnum::SCOPE_FORM,
            'action' => FormActionEnum::UPDATE_FORM
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
