<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\Token;

final class RevokePersonalAccessToken
{
    public function __invoke(OAuthenticatable $user): void
    {
        /** @var Token $token */
        $token = $user->token();

        $token->revoke();
    }
}
