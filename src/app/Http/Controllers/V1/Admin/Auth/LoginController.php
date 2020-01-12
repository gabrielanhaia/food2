<?php

namespace App\Http\Controllers\V1\Admin\Auth;

use App\Exceptions\InvalidUserLogin;

class LoginController extends \App\Http\Controllers\V1\Web\Auth\LoginController
{
    public function rightContext($user)
    {
        if (!$user->is_admin) {
            throw new InvalidUserLogin();
        }
    }

}
