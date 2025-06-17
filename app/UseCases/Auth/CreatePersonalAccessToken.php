<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use Laravel\Passport\Contracts\OAuthenticatable;

final class CreatePersonalAccessToken
{
    public function __invoke(OAuthenticatable $user): string
    {
        $tokenResult = $user->createToken('Personal Access Token');

        return $tokenResult->accessToken;
    }
}
