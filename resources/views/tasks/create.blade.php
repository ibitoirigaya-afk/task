<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク作成</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- 1. FlatpickrのCSS（カレンダーの見た目） -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body class="p-5">

<div class="container">
    <h1>新しいタスクを作る</h1>

    <form action="/tasks" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">説明</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
    <label for="status" class="form-label">状態</label>
    <input type="text" name="status" class="form-control" id="status" placeholder="例: 着手中、確認待ち、保留">
</div>

        <!-- ここ！この「期限」ブロックが2つあったら1つを消してください -->
        <div class="mb-3">
            <label for="due_date" class="form-label">期限</label>
            <input type="text" id="due_date" name="due_date" class="form-control bg-white" placeholder="日付を選択または入力">
        </div>

        <button type="submit" class="btn btn-primary">保存する</button>
        <a href="/tasks" class="btn btn-secondary">戻る</a>
    </form>
</div>
<input type="text" name="status">

<!-- 2. FlatpickrのJS（カレンダーを動かす仕組み） -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#due_date", {
        allowInput: true,   // 直接入力OK
        dateFormat: "Y-m-d" // データベースが理解できる形式
    });
</script>

</body>
</html>