<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// トップページ（/）でタスク一覧を表示
Route::get('/', [TaskController::class, 'index']);

// タスク操作関連
Route::get('/tasks/create', [TaskController::class, 'create']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks/{task}', [TaskController::class, 'show']);
Route::patch('/tasks/{task}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle']);