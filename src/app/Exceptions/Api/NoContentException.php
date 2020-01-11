<?php

namespace App\Exceptions\Api;

use App\Enums\HttpStatusCodeEnum;
use Throwable;

/**
 * Class NoContentException
 * @package App\Exceptions\Api
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class NoContentException extends ApiException
{
    /**
     * NoContentException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(HttpStatusCodeEnum::NO_CONTENT(), $message, $code, $previous);
    }
}
