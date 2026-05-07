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

// ==========================================
// RUTAS PÚBLICAS
// ==========================================

// Auth público
Route::post("login", [App\Http\Controllers\AuthController::class, "login"])->middleware("api");

Route::group([
    "middleware" => ["api"],
    "prefix" => "auth",

], function ($router) {
    Route::post("register", [App\Http\Controllers\AuthController::class, "register"]);
    Route::post("logout", [App\Http\Controllers\AuthController::class, "logout"]);
    Route::post("refresh", [App\Http\Controllers\AuthController::class, "refresh"]);
    Route::get("user-profile", [App\Http\Controllers\AuthController::class, "userProfile"]);
});

// Clubs públicos
Route::get('clubs', [App\Http\Controllers\ClubController::class, 'index']);
Route::get('clubs/slug/{slug}', [App\Http\Controllers\ClubController::class, 'showBySlug']);
Route::get('clubs/{id}', [App\Http\Controllers\ClubController::class, 'show']);

// Canchas públicas
Route::get('clubs/{clubId}/courts', [App\Http\Controllers\CourtController::class, 'index']);
Route::get('courts/{id}', [App\Http\Controllers\CourtController::class, 'show']);
Route::get('courts/{id}/availability', [App\Http\Controllers\CourtController::class, 'checkAvailability']);
Route::get('courts/{id}/available-slots', [App\Http\Controllers\CourtController::class, 'availableSlots']);

// Reseñas públicas
Route::get('reviews', [App\Http\Controllers\ReviewController::class, 'index']);

// Partidos públicos
Route::get('matches', [App\Http\Controllers\MatchController::class, 'index']);
Route::get('matches/{id}', [App\Http\Controllers\MatchController::class, 'show']);

// ==========================================
// RUTAS PROTEGIDAS (Requieren autenticación JWT)
// ==========================================

Route::group([
    "middleware" => ["api", "auth:api"],

], function ($router) {

    // ========== PERFIL DE USUARIO ==========
    $router->get('profile', [App\Http\Controllers\UserProfileController::class, 'show']);
    $router->put('profile', [App\Http\Controllers\UserProfileController::class, 'update']);

    // ========== CLUBS (Protegidas) ==========
    $router->post('clubs', [App\Http\Controllers\ClubController::class, 'store']);
    $router->put('clubs/{id}', [App\Http\Controllers\ClubController::class, 'update']);
    $router->delete('clubs/{id}', [App\Http\Controllers\ClubController::class, 'destroy']);
    $router->get('clubs/{clubId}/members', [App\Http\Controllers\ClubController::class, 'members']);
    $router->post('clubs/{clubId}/members', [App\Http\Controllers\ClubController::class, 'addMember']);

    // ========== CANCHAS (Protegidas) ==========
    $router->post('clubs/{clubId}/courts', [App\Http\Controllers\CourtController::class, 'store']);
    $router->put('courts/{id}', [App\Http\Controllers\CourtController::class, 'update']);
    $router->delete('courts/{id}', [App\Http\Controllers\CourtController::class, 'destroy']);

    // ========== RESERVAS ==========
    $router->get('bookings', [App\Http\Controllers\BookingController::class, 'index']);
    $router->post('bookings', [App\Http\Controllers\BookingController::class, 'store']);
    $router->get('bookings/{id}', [App\Http\Controllers\BookingController::class, 'show']);
    $router->post('bookings/{id}/confirm', [App\Http\Controllers\BookingController::class, 'confirm']);
    $router->post('bookings/{id}/cancel', [App\Http\Controllers\BookingController::class, 'cancel']);
    $router->post('bookings/{bookingId}/invite', [App\Http\Controllers\BookingController::class, 'invitePlayer']);
    $router->post('bookings/{bookingId}/accept-invitation', [App\Http\Controllers\BookingController::class, 'acceptInvitation']);
    $router->post('bookings/{bookingId}/decline-invitation', [App\Http\Controllers\BookingController::class, 'declineInvitation']);

    // ========== PARTIDOS ==========
    $router->post('matches', [App\Http\Controllers\MatchController::class, 'store']);
    $router->put('matches/{id}/score', [App\Http\Controllers\MatchController::class, 'updateScore']);
    $router->post('matches/{matchId}/join', [App\Http\Controllers\MatchController::class, 'join']);
    $router->post('matches/{matchId}/leave', [App\Http\Controllers\MatchController::class, 'leave']);
    $router->get('matchmaking/opponents', [App\Http\Controllers\MatchController::class, 'findOpponents']);

    // ========== PAGOS ==========
    $router->get('payments', [App\Http\Controllers\PaymentController::class, 'index']);
    $router->post('bookings/{bookingId}/pay', [App\Http\Controllers\PaymentController::class, 'process']);
    $router->get('payments/{id}', [App\Http\Controllers\PaymentController::class, 'show']);
    $router->post('payments/{id}/refund', [App\Http\Controllers\PaymentController::class, 'refund']);

    // ========== NOTIFICACIONES ==========
    $router->get('notifications', [App\Http\Controllers\NotificationController::class, 'index']);
    $router->post('notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead']);
    $router->post('notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead']);
    $router->get('notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount']);
    $router->delete('notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy']);

    // ========== RESEÑAS ==========
    $router->post('reviews', [App\Http\Controllers\ReviewController::class, 'store']);
    $router->put('reviews/{id}', [App\Http\Controllers\ReviewController::class, 'update']);
    $router->delete('reviews/{id}', [App\Http\Controllers\ReviewController::class, 'destroy']);
});
