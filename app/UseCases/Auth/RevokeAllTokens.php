<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\Token;

final class RevokeAllTokens
{
    public function __invoke(OAuthenticatable $user): void
    {
        $user->tokens()->each(function (Token $token) {
            $token->revoke();
        });
    }
}
