<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthControllerSuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signup/super-admin', [AuthControllerSuperAdmin::class, 'signupSuperAdmin']);
/* Route::post('/login', [AuthControllerSuperAdmin::class, 'loginSuperAdmin']); */
Route::post('/logout', [AuthControllerSuperAdmin::class, 'logoutSuperAdmin']);

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
