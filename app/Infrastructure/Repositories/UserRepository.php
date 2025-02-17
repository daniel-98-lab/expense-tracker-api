<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User as DomainUser;
use App\Domain\Interfaces\UserRepositoryInterface;
use App\Infrastructure\Models\User as EloquentUser;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository implements UserRepositoryInterface
{
    
    /**
     * Retrieves a user by its ID.
     *
     * @param int $id The ID of the user to retrieve.
     * @return DomainUser|null Returns the user if found, or null if not found.
     */
    public function getById(int $id): ?DomainUser 
    {
        $user = EloquentUser::find($id);
        return $user ? new DomainUser($user->id, $user->name, $user->email, $user->password) : null;
    }

    /**
     * Attempt to authenticate a user and return a JWT token if successful.
     *
     * @param string $email The user's email address.
     * @param string $password The user's password.
     * @return string|null The JWT token if authentication is successful, or null if it fails.
     */
    public function login(string $email, string $password): ?string 
    {
        $credentials = ['email' => $email, 'password' => $password];
        if (!$token = JWTAuth::attempt($credentials)) {
            return null;
        }
        
        return $token;
    }

    /**
     * Logout the authenticated user by invalidating the token.
     *
     * @return null Always returns null after logging out the user.
     */
    public function logout(): null
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        Auth::logout();
        return null;
    }

    /**
     * Refresh the JWT token for an authenticated user.
     *
     * @return string The new token or null if the token is invalid.
     */
    public function refreshToken(): ?string
    {
        try {
            $token = JWTAuth::getToken();
            $token = JWTAuth::refresh();
            JWTAuth::invalidate(JWTAuth::getToken());
            return $token;
        } catch (\Throwable $th) {
            return null;
        }
        return null;
    }
}