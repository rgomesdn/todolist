<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiTaskController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [AuthController::class, 'login']);

// AUTH ROUTES
Route::middleware('auth:sanctum')->get('/tasks/', [ApiTaskController::class, 'index']);
Route::middleware('auth:sanctum')->post('/tasks/create', [ApiTaskController::class, 'store']);
Route::middleware('auth:sanctum')->post('/tasks/read', [ApiTaskController::class, 'show']);
Route::middleware(['auth:sanctum', 'CheckTaskOwner'])->post('/tasks/update', [ApiTaskController::class, 'update']);
Route::middleware(['auth:sanctum', 'CheckTaskOwner'])->post('/tasks/delete', [ApiTaskController::class, 'destroy']);
