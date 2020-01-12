<?php

namespace App\Service\Webhooks\Scopes\Forms;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class FormActionEnum
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class FormActionEnum extends AbstractEnumeration
{
    /** @var string CREATE_FORM */
    const CREATE_FORM = 'create';

    /** @var string UPDATE_FORM */
    const UPDATE_FORM = 'update';
}
