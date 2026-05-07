<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Velora Laravel 10 API",
 *      description="API para el sistema de autenticación y registro de Velora en Laravel 10",
 *      @OA\Contact(
 *          email="admin@velora.com"
 *      ),
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Servidor de la API de Velora"
 * )
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @OA\Post(
     *      path="/api/login",
     *      operationId="loginUser",
     *      tags={"Auth"},
     *      summary="Iniciar sesión de usuario",
     *      description="Autentica un usuario y crea una nueva sesión",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", format="email", example="admin@velora.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Sesión iniciada correctamente"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error de validación"
     *      )
     * )
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     *
     * @OA\Post(
     *      path="/api/logout",
     *      operationId="logoutUser",
     *      tags={"Auth"},
     *      summary="Cerrar sesión de usuario",
     *      description="Cierra la sesión del usuario autenticado",
     *      security={{"sanctum": {}}},
     *      @OA\Response(
     *          response=204,
     *          description="Sesión cerrada correctamente"
     *      )
     * )
     */
    public function destroy(Request $request): Response
    {
        Auth::guard("web")->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
