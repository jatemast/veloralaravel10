<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    /**
     * Registrar un nuevo usuario.
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Crear perfil por defecto
        $user->profile()->create([
            'skill_level' => 1,
        ]);

        return $user;
    }

    /**
     * Iniciar sesión y obtener token JWT.
     */
    public function login(array $credentials): ?string
    {
        if (!$token = auth('api')->attempt($credentials)) {
            return null;
        }

        return $token;
    }

    /**
     * Cerrar sesión (invalidar token).
     */
    public function logout(): void
    {
        auth('api')->logout();
    }

    /**
     * Refrescar token JWT.
     */
    public function refresh(): string
    {
        return JWTAuth::refresh();
    }

    /**
     * Obtener el usuario autenticado.
     */
    public function userProfile(): ?User
    {
        return auth('api')->user();
    }

    /**
     * Responder con token JWT.
     */
    public function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => auth('api')->user(),
        ];
    }
}
