<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/super-admin', function (Request $request) {
        return $request->user();
    });
    Route::get('/alumno', function (Request $request) {
        return $request->user();
    });
});
Route::post('/signup/super-admin', [AuthController::class, 'signupSuperAdmin']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

require __DIR__ . '/auth.php';
