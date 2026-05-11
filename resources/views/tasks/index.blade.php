<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .completed {
            text-decoration: line-through;
            background-color: #f8f9fa !important;
            color: #adb5bd;
        }
        /* バッジの形を整える */
        .badge { font-weight: normal; padding: 0.5em 0.8em; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0">マイ・タスク一覧</h1>
            <a href="/tasks/create" class="btn btn-light btn-sm">＋ 新規作成</a>
        </div>
        
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">完了</th>
                        <th>タイトル</th>
                        <th>期限</th>
                        <th class="text-end">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    @php
                        // --- 期限の色判定ロジック ---
                        $colorClass = 'bg-secondary text-white'; // デフォルト：灰色
                        
                        if ($task->due_date && !$task->is_completed) {
                            $dueDate = \Carbon\Carbon::parse($task->due_date);
                            $now = \Carbon\Carbon::now()->startOfDay();
                            $diffDays = $now->diffInDays($dueDate, false); // 今日との差分

                            if ($diffDays <= 3) {
                                $colorClass = 'bg-danger text-white';   // 3日以内：赤
                            } elseif ($diffDays <= 7) {
                                $colorClass = 'bg-warning text-dark';  // 1週間以内：黄
                            } elseif ($diffDays >= 30) {
                                $colorClass = 'bg-success text-white'; // 1ヶ月以上：緑
                            } else {
                                $colorClass = 'bg-info text-dark';     // それ以外：水色
                            }
                        }
                    @endphp

                    <tr class="{{ $task->is_completed ? 'completed' : '' }}">
                        <td>
                            <form action="/tasks/{{ $task->id }}/toggle" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="checkbox" class="form-check-input" onChange="this.form.submit()" {{ $task->is_completed ? 'checked' : '' }}>
                            </form>
                        </td>
                        <td class="align-middle">{{ $task->title }}</td>
                        <td class="align-middle">
                            <!-- ここで判定したクラス ($colorClass) を適用しています -->
                            <span class="badge {{ $colorClass }}">
                                {{ $task->due_date ?? '未設定' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <form action="/tasks/{{ $task->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>