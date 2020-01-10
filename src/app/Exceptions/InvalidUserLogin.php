<?php

namespace App\Exceptions;

class InvalidUserLogin extends \Exception
{
    protected $message = "User invalid for this context";
}
