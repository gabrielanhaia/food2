<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Exceptions\InvalidUserLogin;

class LoginController extends \App\Http\Controllers\Web\Auth\LoginController
{
    public function rightContext($user)
    {
        if (!$user->is_admin) {
            throw new InvalidUserLogin();
        }
    }

}
