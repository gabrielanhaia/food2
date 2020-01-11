<?php

namespace App\Exceptions\Api;

use App\Enums\HttpStatusCodeEnum;
use Throwable;

/**
 * Class GoneException
 * @package App\Exceptions\Api
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class GoneException extends ApiException
{
    /**
     * GoneException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(HttpStatusCodeEnum::GONE(), $message, $code, $previous);
    }
}
