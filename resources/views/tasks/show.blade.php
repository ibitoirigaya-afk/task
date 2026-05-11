<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク詳細 - {{ $task->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between">
                    <span>タスク詳細</span>
                    <span>ID: {{ $task->id }}</span>
                </div>
                <div class="card-body">
                    <!-- 状態更新用のフォーム -->
                    <form action="/tasks/{{ $task->id }}/update-status" method="POST" class="mb-4">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row g-2 align-items-end">
                            <div class="col-md-8">
                                <h1 class="h3 mb-3">{{ $task->title }}</h1>
                            </div>
                            <div class="col-md-4 text-end">
                                <label class="form-label small text-muted">現在の状態</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="status" class="form-control" value="{{ $task->status }}" placeholder="例: 実行中">
                                    <button class="btn btn-primary" type="submit">更新</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <div class="mb-4">
                        <label class="text-muted small d-block">期限</label>
                        <span class="badge bg-info text-dark">{{ $task->due_date ?? '未設定' }}</span>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small d-block">説明</label>
                        <div class="p-3 border rounded bg-light" style="white-space: pre-wrap;">{{ $task->description ?: '説明はありません。' }}</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/tasks" class="btn btn-secondary">戻る</a>
                        
                        <form action="/tasks/{{ $task->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>