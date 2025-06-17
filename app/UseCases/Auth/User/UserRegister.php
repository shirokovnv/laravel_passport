<?php

declare(strict_types=1);

namespace App\UseCases\Auth\User;

use App\Models\User;
use Carbon\Carbon;

final class UserRegister
{
    public function __invoke(string $name, string $email, string $password): User
    {
        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');

        $user->save();

        return $user;
    }
}
