<?php

namespace App\Service\Webhooks;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 *
 * @method static $this GET_PARAM()
 * @method static $this POST_BODY()
 * @method static $this POST_HEADER()
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */

/**
 * Class WebhookExtraDataEnum
 * @package App\Enums
 */
class WebhookExtraDataEnum extends AbstractEnumeration
{
    /** @var string GET_PARAM  */
    const GET_PARAM = 'GET_PARAM';

    /** @var string POST_BODY */
    const POST_BODY = 'POST_BODY';

    /** @var string POST_HEADER  */
    const POST_HEADER = 'POST_HEADER';
}
