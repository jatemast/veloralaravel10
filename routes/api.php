<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Ruta pública de login (sin prefijo auth para compatibilidad)
Route::post("login", [App\Http\Controllers\AuthController::class, "login"])->middleware("api");

// Rutas agrupadas con prefijo "auth"
Route::group([
    "middleware" => ["api"],
    "prefix" => "auth",

], function ($router) {

    // Públicas
    Route::post("register", [App\Http\Controllers\AuthController::class, "register"]);

    // Protegidas (el middleware auth:api se aplica en el constructor del controlador)
    Route::post("logout", [App\Http\Controllers\AuthController::class, "logout"]);
    Route::post("refresh", [App\Http\Controllers\AuthController::class, "refresh"]);
    Route::get("user-profile", [App\Http\Controllers\AuthController::class, "userProfile"]);
});
