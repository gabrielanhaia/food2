<?php


namespace App\Service\Webhooks\Scopes\Forms;

use App\Service\Webhooks\Scopes\Forms\Actions\{Create, Update};
use App\Service\Weebhooks\Contracts\DefaultAction;

/**
 * Class WeebhookFormFactory
 * @package App\Service\Webhooks\Scopes\Forms
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class WebHookFormFactory
{
    /**
     * @var FormActionEnum
     */
    private $actionEnum;

    /**
     * WebHookFormFactory constructor.
     * @param FormActionEnum $actionEnum
     */
    public function __construct(FormActionEnum $actionEnum)
    {
        $this->actionEnum = $actionEnum;
    }

    /**
     * @param null $firstParam
     * @return DefaultAction
     * @throws \Exception
     */
    public function make($firstParam = null): DefaultAction
    {
        switch ($this->actionEnum->value()) {
            case FormActionEnum::CREATE_FORM:
                return new Create($firstParam);
                break;
            case FormActionEnum::UPDATE_FORM:
                return new Update($firstParam);
                break;
            default:
                throw new \Exception('Action not implemented.');
        }
    }
}
