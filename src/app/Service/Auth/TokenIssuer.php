<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\PersonalAccessTokenResult;
use Psr\Http\Message\ServerRequestInterface;


class TokenIssuer
{


    /**
     * @param ServerRequestInterface $request
     * @param AccessTokenController $accessTokenController
     * @return \Illuminate\Http\Response
     * @throws AuthenticationException
     */
    public static function issueToken(ServerRequestInterface $request, AccessTokenController $accessTokenController)
    {

        $client = \Laravel\Passport\Client::where('password_client', 1)->first();

        $oauthData = [
            'email'         => $request->getParsedBody()['email'],
            'password'      => $request->getParsedBody()['password'],
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'scope'         => '*',
        ];

        $request = $request->withParsedBody($oauthData);

        $tokenData = $accessTokenController->issueToken($request);


        if ($tokenData->getStatusCode() == 401) {
            throw new AuthenticationException();
        }

        return $tokenData;
    }


    public static function issueTokenForUser(User $user)
    {
        /**
         * @var PersonalAccessTokenResult $personalAccessTokenResults
         */
        $personalAccessTokenResults = $user->createToken("admin_user_impersonate", ["*"]);

        return [
            "token_type"   => "Bearer",
            "access_token" => $personalAccessTokenResults->accessToken,
            "expires_in"   => Carbon::now()->diffInSeconds($personalAccessTokenResults->token->expires_at),
            "domain"       => env('DOMAIN_NAME'),
            "url"          => env('APP_URL'),
        ];
    }
}
