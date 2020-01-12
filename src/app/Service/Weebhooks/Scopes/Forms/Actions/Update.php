<?php

namespace App\Service\Webhooks\Scopes\Forms\Actions;

use App\Models\Form;
use App\Service\Webhooks\Scopes\Forms\FormActionEnum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class Update
 * @package App\Service\Webhooks\Scopes\Forms\Actions
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class Update extends DefaultFormAction
{
    /** @var int $formId */
    private $formId;

    public function __construct(int $formId)
    {
        $this->formId = $formId;
    }

    /**
     * Return data to be sent by webhook call.
     *
     * @return array
     */
    public function getData(): array
    {
        $form = Form::find($this->formId);
        $user = User::find($form->user_id);

        return [
            'id' => $form->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'start_publish' => $form->start_publish,
            'end_publish' => $form->end_publish,
        ];
    }

    /**
     * @return AbstractEnumeration
     */
    protected function getActionEnum(): AbstractEnumeration
    {
        return FormActionEnum::UPDATE_FORM();
    }
}
