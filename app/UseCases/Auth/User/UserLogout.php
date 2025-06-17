<?php

declare(strict_types=1);

namespace App\UseCases\Auth\User;

use Illuminate\Auth\AuthManager;

final class UserLogout
{
    public function __construct(private readonly AuthManager $authManager)
    {
    }

    public function __invoke(): void
    {
        $this->authManager->logout();
    }
}
