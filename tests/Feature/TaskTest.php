<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    // テスト実行ごとにDBをリセットする（Javaの @Before 相当の便利機能）
    use RefreshDatabase;

    /** @test */
    public function test_タスクが正常に作成できること()
    {
        // 1. 投稿データを用意
        $data = [
            'title' => 'テスト用のタスク',
            'status' => '実行中',
            'due_date' => '2026-12-31',
            'description' => 'テスト詳細です'
        ];

        // 2. 投稿処理をシミュレート（POSTリクエスト）
        $response = $this->post('/tasks', $data);

        // 3. アサーション（検証）
        // 一覧画面にリダイレクトされるか
        $response->assertRedirect('/tasks');
        
        // データベースに指定した値があるか
        $this->assertDatabaseHas('tasks', [
            'title' => 'テスト用のタスク',
            'status' => '実行中'
        ]);
    }

    /** @test */
    public function test_タイトルが空の場合はバリデーションエラーになること()
    {
        $response = $this->post('/tasks', ['title' => '']);
        
        // セッションにエラーがあるか
        $response->assertSessionHasErrors(['title']);
    }
}