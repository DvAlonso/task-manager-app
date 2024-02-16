<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', LoginController::class)->name('api:login');

Route::middleware('auth:sanctum')->group(function() {

    // User list
    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('api:users:index');
    });

    // Task management routes
    Route::prefix('tasks')->group(function() {
        Route::get('/', [TaskController::class, 'index'])->name('api:tasks:index');
        Route::get('/{task}', [TaskController::class, 'show'])->name('api:tasks:show');
        Route::post('/', [TaskController::class, 'store'])->name('api:tasks:store');
        Route::put('/{task}', [TaskController::class, 'update'])->name('api:tasks:update');
        Route::put('/{task}/assign', [TaskController::class, 'assign'])->name('api:tasks:assign');
        Route::put('/{task}/status', [TaskController::class, 'move'])->name('api:tasks:status');
        Route::delete('/{task}', [TaskController::class, 'delete'])->name('api:tasks:delete');
    });
});
