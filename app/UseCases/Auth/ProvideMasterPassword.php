<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use Illuminate\Contracts\Config\Repository as ConfigRepository;

final class ProvideMasterPassword
{
    public function __construct(private readonly ConfigRepository $config)
    {
    }

    public function __invoke(): ?string
    {
        return $this->config->get('auth.passwords.master_password_hash');
    }
}
