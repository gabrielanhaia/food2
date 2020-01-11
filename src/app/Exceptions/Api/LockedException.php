<?php

namespace App\Exceptions\Api;

use App\Enums\HttpStatusCodeEnum;
use Throwable;

/**
 * Class LockedException
 * @package App\Exceptions\Api
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class LockedException extends ApiException
{
    /**
     * InternalServerErrorException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(HttpStatusCodeEnum::LOCKED(), $message, $code, $previous);
    }
}
