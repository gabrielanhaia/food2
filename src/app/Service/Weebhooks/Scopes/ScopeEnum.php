<?php

namespace App\Service\Webhooks\Scopes;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class ScopeEnum
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class ScopeEnum extends AbstractEnumeration
{
    /** @var string SCOPE_FORM */
    const SCOPE_FORM = 'form';

    /** @var string SCOPE_ANOTHER */
    const SCOPE_ANOTHER = 'another_example';
}
