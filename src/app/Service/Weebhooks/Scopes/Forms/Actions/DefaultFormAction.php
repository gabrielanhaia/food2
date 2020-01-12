<?php


namespace App\Service\Webhooks\Scopes\Forms\Actions;

use App\Service\Webhooks\Scopes\ScopeEnum;
use App\Service\Weebhooks\Contracts\DefaultAction;
use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class DefaultFormAction
 * @package App\Service\Webhooks\Scopes\Forms\Actions
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmai.com>
 */
abstract class DefaultFormAction extends DefaultAction
{
    /**
     * @return AbstractEnumeration
     */
    protected function getScopeEnum(): AbstractEnumeration
    {
        return ScopeEnum::SCOPE_FORM();
    }
}
