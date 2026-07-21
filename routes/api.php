<?php

use App\Http\Controllers\Api\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes  (prefix: /api)
|--------------------------------------------------------------------------
|
| These routes are used by the Vue/Capacitor mobile application.
| Authentication is Sanctum token-based (Bearer tokens), not session-based.
|
*/

// ── Public: Auth ──────────────────────────────────────────────────────────────
Route::post('/login',        [ApiAuthController::class, 'login']);
Route::post('/staff/login',  [ApiAuthController::class, 'staffLogin']);
Route::post('/register',     [ApiAuthController::class, 'register']);

// ── Protected: requires valid Bearer token ─────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user',          [ApiAuthController::class, 'user']);
    Route::post('/logout',       [ApiAuthController::class, 'logout']);
    Route::post('/staff/logout', [ApiAuthController::class, 'logout']);
});
