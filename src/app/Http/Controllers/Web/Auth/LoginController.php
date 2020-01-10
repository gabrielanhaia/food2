<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\TokenIssuer;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\InvalidUserLogin;
use App\Exceptions\UserUnactivatedException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @param $user
     */
    public function rightContext($user)
    {
        //admins can login in web area
    }

    public function login(Request $request)
    {
        $data = $request->input();
        $user = User::where('email', $data['login'])->first();

        if (!$user) {
            throw new InvalidUserLogin();
        }

        $this->rightContext($user);

        if (!$user->email_verified_at) {
            throw new UserUnactivatedException();
        }

        if (Auth::attempt([
            'email' => $user->email,
            'password' => $data['password'],
        ])) {
            return  response()->json([
                'token' => $this->issueTokenForUser($user),
                'user' => $user,
            ]);

        } else {
            throw new InvalidUserLogin();
        }
    }

    public function logout(Request $request)
    {
        return response()->json(
            $request->user()->token()->revoke()
        );
    }

    public function issueTokenForUser(User $user)
    {
        return TokenIssuer::issueTokenForUser($user);
    }
}
