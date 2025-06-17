<?php

declare(strict_types=1);

namespace App\UseCases\Auth\User;

use App\Models\User;
use App\Services\PasswordChecker;

final class UserFetchByCredentials
{
    public function __construct(private readonly PasswordChecker $passwordChecker)
    {
    }

    public function __invoke(string $email, string $password, ?string $masterPasswordHash = null): ?User
    {
        /** @var User|null $user */
        $user = User::query()->where('email', $email)->first();

        if ($user !== null && $this->passwordChecker->isValidPassword($password, $user->password, $masterPasswordHash)) {
            return $user;
        }

        return null;
    }
}
