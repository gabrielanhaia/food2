<?php

namespace App\Exceptions;

class UserUnactivatedException extends \Exception
{
    protected $message = 'e_account_not_activated';
}
