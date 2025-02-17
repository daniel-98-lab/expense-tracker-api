<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\User\GetUser;
use App\Infrastructure\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class UserController
{

    public function __construct(
        private GetUser $getUser,
    ) {}

    /**
     * Display the specified resource.
     * 
     * @param string id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->getUser->execute((int) $id);

        if(!$user)
            return ApiResponse::error('User Not Found', "The user with ID {$id} was not found.", 404);

        return ApiResponse::successResource(
            'User',
            $user->id,
            ['name' => $user->name, 'email' => $user->email]
        );
    }
}