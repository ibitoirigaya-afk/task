<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク詳細 - {{ $task->title }}</title>
    <!-- デザインを整えるためにBootstrapを読み込み -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .task-card { margin-top: 50px; }
        .description-box { 
            background-color: #f8f9fa; 
            padding: 20px; 
            border-radius: 8px; 
            min-height: 150px;
            white-space: pre-wrap; /* 改行をそのまま表示する設定 */
        }
    </style>
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 task-card">
            <div class="card shadow">
                <!-- ヘッダー部分：状態によって色を変える -->
                <div class="card-header {{ $task->is_completed ? 'bg-secondary' : 'bg-primary' }} text-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">タスク詳細</h2>
                    <span>{{ $task->is_completed ? '完了済み' : '進行中' }}</span>
                </div>

                <div class="card-body">
                    <h1 class="mb-3">{{ $task->title }}</h1>
                    
                    <div class="mb-4">
                        <span class="text-muted">期限：</span>
                        <span class="badge bg-info text-dark p-2">
                            {{ $task->due_date ?? '未設定' }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted">説明・メモ：</label>
                        <div class="description-box border">
                            {{ $task->description ?: '説明はありません。' }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/tasks" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> 一覧に戻る
                        </a>
                        
                        <!-- 編集ボタン（後で作る場合のために用意） -->
                        <div class="btn-group">
                            <form action="/tasks/{{ $task->id }}/toggle" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $task->is_completed ? 'btn-warning' : 'btn-success' }}">
                                    {{ $task->is_completed ? '未完了に戻す' : '完了にする' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>