<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/super-admin', function (Request $request) {
        return $request->user();
    });
    Route::get('/super-admin/administration', [StudentController::class, 'index']);
    Route::delete('/super-admin/administration/{id}', [StudentController::class, 'destroy']);
    Route::patch('/students/{id}', [StudentController::class, 'updateApprovalStatus']);

});

Route::post('/signup/super-admin', [AuthController::class, 'signupSuperAdmin']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

