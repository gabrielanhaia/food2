<?php

namespace App\Exceptions\Api;

use App\Enums\HttpStatusCodeEnum;
use Throwable;

/**
 * Class MethodNotAllowedException
 * @package App\Exceptions\Api
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class MethodNotAllowedException extends ApiException
{
    /**
     * MethodNotAllowedException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(HttpStatusCodeEnum::METHOD_NOT_ALLOWED(), $message, $code, $previous);
    }
}
