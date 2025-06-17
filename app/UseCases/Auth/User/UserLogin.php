<?php

declare(strict_types=1);

namespace App\UseCases\Auth\User;

use App\Models\User;
use App\Services\PasswordChecker;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Hashing\Hasher;
use Laravel\Passport\Exceptions\AuthenticationException;

final class UserLogin
{
    public function __construct(
        private readonly PasswordChecker $passwordChecker,
        private readonly AuthManager $authManager
    )
    {
    }

    /**
     * @throws AuthenticationException
     */
    public function __invoke(string $email, string $password, ?string $masterPasswordHash = null): User
    {
        /** @var User|null $user */
        $user = User::query()->where('email', $email)->first();

        if ($user === null || !$this->passwordChecker->isValidPassword($password, $user->password, $masterPasswordHash)) {
            throw new AuthenticationException("Invalid credentials.");
        }

        if (!$user->hasVerifiedEmail()) {
            throw new AuthenticationException("You must verify your email first.");
        }

        $this->authManager->setUser($user);

        return $user;
    }
}
