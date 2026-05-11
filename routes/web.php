<?php

use Illuminate\Support\Facades\Route; // これを一番上に持ってくるのがお作法
use App\Http\Controllers\TaskController;

// 1. テスト用（http://127.0.0.1:8000/hello で確認）
Route::get('/hello', function () {
    return 'Hello, World!';
});

// 2. タスク作成画面を表示する道
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

// 3. タスクを保存する道
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// ※ Route::resource は一旦消しておきましょう。
// 自分で1つずつ定義したほうが、今は学習しやすくエラーも出にくいです。
// 一覧表示画面
Route::get('/tasks', [TaskController::class, 'index']);

// 削除処理
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle']);

Route::get('/tasks/{task}', [TaskController::class, 'show']);
Route::patch('/tasks/{task}/update-status', [TaskController::class, 'updateStatus']);