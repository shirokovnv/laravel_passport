<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\CreateTokenRequest;
use App\Models\User;
use App\UseCases\Auth\CreatePersonalAccessToken;
use App\UseCases\Auth\ProvideMasterPassword;
use App\UseCases\Auth\RevokePersonalAccessToken;
use App\UseCases\Auth\RevokeAllTokens;
use App\UseCases\Auth\User\UserFetchByCredentials;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\Exceptions\AuthenticationException;

class TokenController extends Controller
{
    /**
     * @throws AuthenticationException
     */
    public function createAccessToken(
        CreateTokenRequest        $request,
        CreatePersonalAccessToken $accessTokenUseCase,
        UserFetchByCredentials    $userFetchByCredentialsUseCase,
        ProvideMasterPassword     $provideMasterPasswordUseCase
    ): JsonResponse
    {
        /** @var User|null $user */
        $user = $userFetchByCredentialsUseCase(
            $request->getUserEmail(),
            $request->getUserPassword(),
            $provideMasterPasswordUseCase()
        );

        if ($user === null) {
            throw new AuthenticationException("Invalid credentials.");
        }

        $token = $accessTokenUseCase($user);

        return new JsonResponse(['token' => $token]);
    }

    /**
     * @throws AuthenticationException
     */
    public function revokeToken(
        AuthManager $authManager,
        RevokePersonalAccessToken $revokeTokenUseCase
    ): JsonResponse
    {
        $user = $authManager->user();

        if (!$user instanceof OAuthenticatable) {
            throw new AuthenticationException("Invalid user.");
        }

        $revokeTokenUseCase($user);

        return new JsonResponse([]);
    }

    /**
     * @throws AuthenticationException
     */
    public function revokeAllTokens(
        AuthManager $authManager,
        RevokeAllTokens $revokeAllTokensUseCase
    ): JsonResponse
    {
        $user = $authManager->user();

        if (!$user instanceof OAuthenticatable) {
            throw new AuthenticationException("Invalid user.");
        }

        $revokeAllTokensUseCase($user);

        return new JsonResponse([]);
    }
}
