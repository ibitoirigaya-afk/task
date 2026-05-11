<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク編集 - {{ $task->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body class="bg-light p-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h1 class="h6 mb-0">タスクの編集</h1>
                    <small>ID: {{ $task->id }}</small>
                </div>
                <div class="card-body">
                    <form action="/tasks/{{ $task->id }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- タイトル -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">タイトル</label>
                            <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $task->title) }}" required>
                        </div>

                        <div class="row">
                            <!-- 状態 -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small">状態</label>
                                <input type="text" name="status" class="form-control" value="{{ old('status', $task->status) }}" placeholder="例: 実行中">
                            </div>
                            <!-- 期限 -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small">期限</label>
                                <input type="text" name="due_date" id="due_date" class="form-control bg-white" value="{{ old('due_date', $task->due_date) }}">
                            </div>
                        </div>

                        <!-- 説明 -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">詳細・メモ</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="/tasks" class="btn btn-secondary">キャンセル</a>
                                <button type="submit" class="btn btn-primary px-4">変更を保存</button>
                            </div>
                            
                            <!-- 削除ボタン -->
                        </div>
                    </form>
                    
                    <div class="mt-3 text-end">
                        <form action="/tasks/{{ $task->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger text-decoration-none small" onclick="return confirm('本当に削除しますか？')">このタスクを削除する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ja.js"></script>
<script>
    flatpickr("#due_date", {
        locale: "ja",
        dateFormat: "Y-m-d",
    });
</script>
</body>
</html>