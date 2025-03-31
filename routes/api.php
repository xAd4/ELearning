<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* 
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
| Routes related to user authentication.
| Includes registration, login, and logout.
*/
Route::middleware("throttle:auth")->group(function () {
    // Registro y login
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);

    // Logout (requiere autenticación)
    Route::middleware("auth:sanctum")->group(function () {
        Route::post("logout", [AuthController::class, "logout"]);
    });
});
