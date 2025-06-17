<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Hashing\Hasher;

final class PasswordChecker
{
    public function __construct(private readonly Hasher $hasher)
    {
    }

    public function isValidPassword(string $plainPassword, string $passwordHash, ?string $masterPasswordHash): bool
    {
        if ($masterPasswordHash !== null && $this->hasher->check($plainPassword, $masterPasswordHash)) {
            return true;
        }

        return $this->hasher->check($plainPassword, $passwordHash);
    }
}
