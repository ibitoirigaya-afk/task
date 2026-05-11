<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規タスク作成</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Flatpickr (カレンダー選択用) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body class="bg-light p-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h1 class="h5 mb-0">新規タスク作成</h1>
                </div>
                <div class="card-body">
                    <form action="/tasks" method="POST">
                        @csrf

                        <!-- タイトル -->
                        <div class="mb-3">
                            <label for="title" class="form-label">タイトル</label>
                            <input type="text" name="title" class="form-control" id="title" required placeholder="例: 会議の資料作成">
                        </div>

                        <!-- 状態 (一つに集約) -->
                        <div class="mb-3">
                            <label for="status" class="form-label">状態</label>
                            <input type="text" name="status" class="form-control" id="status" placeholder="例: 未着手、着手中">
                        </div>

                        <!-- 期限 (カレンダー選択) -->
                        <div class="mb-3">
                            <label for="due_date" class="form-label">期限</label>
                            <input type="text" name="due_date" class="form-control bg-white" id="due_date" placeholder="日付を選択">
                        </div>

                        <!-- 説明 -->
                        <div class="mb-3">
                            <label for="description" class="form-label">説明</label>
                            <textarea name="description" class="form-control" id="description" rows="3" placeholder="タスクの詳細を入力してください"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/tasks" class="btn btn-secondary">戻る</a>
                            <button type="submit" class="btn btn-primary px-4">保存する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flatpickrのスクリプト -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ja.js"></script>
<script>
    flatpickr("#due_date", {
        locale: "ja",
        dateFormat: "Y-m-d",
        minDate: "today",
    });
</script>
</body>
</html>