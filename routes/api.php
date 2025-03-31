<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursePaidController;
use App\Http\Controllers\CoursesPaidController;
use App\Http\Controllers\QAndQController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\SectionController;
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

Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource("carts", CartController::class);
    Route::apiResource("categories", CategoryController::class);
    Route::apiResource("content", ContentController::class);
    Route::apiResource("courses", CourseController::class);
    Route::apiResource("course/paid", CoursePaidController::class);
    Route::apiResource("courses/paid", CoursesPaidController::class);
    Route::apiResource("qandq", QAndQController::class);
    Route::apiResource("responses", ResponseController::class);
    Route::apiResource("reviews", ReviewsController::class);
    Route::apiResource("sections", SectionController::class);
});
