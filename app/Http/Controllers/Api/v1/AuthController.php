<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\UserLoginRequest;
use App\Http\Requests\Api\v1\UserRegisterRequest;
use App\UseCases\Auth\ProvideMasterPassword;
use App\UseCases\Auth\User\UserLogin;
use App\UseCases\Auth\User\UserLogout;
use App\UseCases\Auth\User\UserRegister;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Exceptions\AuthenticationException;

class AuthController extends Controller
{
    /**
     * @throws AuthenticationException
     */
    public function login(
        UserLoginRequest $request,
        UserLogin $userLoginUseCase,
        ProvideMasterPassword $provideMasterPasswordUseCase
    ): JsonResponse
    {
        $user = $userLoginUseCase(
            $request->getUserEmail(),
            $request->getUserPassword(),
            $provideMasterPasswordUseCase()
        );

        return new JsonResponse($user);
    }

    public function register(
        UserRegisterRequest $request,
        UserRegister $userRegisterUseCase
    ): JsonResponse
    {
        $user = $userRegisterUseCase(
            $request->getUserName(),
            $request->getUserEmail(),
            $request->getUserPassword()
        );

        return new JsonResponse($user);
    }

    public function logout(UserLogout $userLogoutUseCase): JsonResponse
    {
        $userLogoutUseCase();

        return new JsonResponse([]);
    }
}
