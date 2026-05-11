<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h1 class="mb-4">タスク一覧</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="/tasks/create" class="btn btn-success">新規作成</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>説明</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>
                    <!-- 削除ボタン（Laravelでは安全のためFormで送るのが一般的） -->
                    <form action="/tasks/{{ $task->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE') <!-- これでDELETEリクエストとして扱う -->
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>