<?php


namespace App\Service\Webhooks\Scopes\Forms;

use App\Service\Webhooks\Scopes\Forms\Actions\Create;
use App\Service\Webhooks\Scopes\Forms\Actions\Update;
use App\Service\Weebhooks\Contracts\ActionInterface;

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
     * @return ActionInterface
     * @throws \Exception
     */
    public function make(): ActionInterface
    {
        switch ($this->actionEnum->value()) {
            case FormActionEnum::CREATE_FORM:
                return new Create;
                break;
            case FormActionEnum::UPDATE_FORM:
                return new Update;
                break;
            default:
                throw new \Exception('Action not implemented.');
        }
    }
}
