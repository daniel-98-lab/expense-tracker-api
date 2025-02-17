<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\User\LoginUser;
use App\Application\UseCases\User\LogoutUser;
use App\Application\UseCases\User\RefreshTokenUser;
use App\Infrastructure\Http\Requests\UserRequest;
use App\Infrastructure\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class AuthController
{

    public function __construct(
        private LoginUser $loginUser,
        private LogoutUser $logoutUser,
        private RefreshTokenUser $refreshTokenUser,
    ) {}

    /**
     * Handle user login and return a JWT token if successful.
     * 
     * @param UserRequest $userRequest The request containing user credentials.
     * @return JsonResponse The response with the token or an error message.
     */
    public function login(UserRequest $userRequest): JsonResponse
    {

        $token = $this->loginUser->execute($userRequest['data.attributes.email'], $userRequest['data.attributes.password']);

        if(!$token)
            return ApiResponse::error('Unauthorized', 'Invalid credentials.', 401);

        return ApiResponse::successResource(
            'tokens',
            uniqid(),
            [
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => config('jwt.ttl') * 60,
            ]
        );
    }

    /**
     * Logout the authenticated user.
     *
     * @return JsonResponse A JSON response confirming logout.
     */
    public function logout(): JsonResponse
    {
        $this->logoutUser->execute();
        return ApiResponse::success(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh the JWT token for an authenticated user.
     *
     * @return JsonResponse The new token or null if the token is invalid.
     */
    public function refreshToken(): JsonResponse
    {
        $token = $this->refreshTokenUser->execute();

        if(!$token)
            return ApiResponse::error('Unauthorized', 'Invalid token.', 401);
        
        return ApiResponse::successResource(
            'tokens',
            uniqid(),
            [
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => config('jwt.ttl') * 60,
            ]
        );
    }

}