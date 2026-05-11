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
        /* カレンダー内のフォントサイズを少し小さくしてスッキリさせる */
        .fc { font-size: 0.9em; }
    </style>
    <!-- FullCalendar CDN -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
</head>
<body class="bg-light">

<div class="container py-5">
    <!-- 1. タスク一覧カード -->
    <div class="row justify-content-center">
        <div class="col-md-10">
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
                                $colorClass = 'bg-secondary text-white'; 
                                
                                if ($task->due_date && !$task->is_completed) {
                                    $dueDate = \Carbon\Carbon::parse($task->due_date);
                                    $now = \Carbon\Carbon::now()->startOfDay();
                                    $diffDays = $now->diffInDays($dueDate, false);

                                    if ($diffDays <= 3) {
                                        $colorClass = 'bg-danger text-white';
                                    } elseif ($diffDays <= 7) {
                                        $colorClass = 'bg-warning text-dark';
                                    } elseif ($diffDays >= 30) {
                                        $colorClass = 'bg-success text-white';
                                    } else {
                                        $colorClass = 'bg-info text-dark';
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
                                <td class="align-middle">
                                    <a href="/tasks/{{ $task->id }}" class="text-decoration-none fw-bold text-dark">
                                        {{ $task->title }}
                                    </a>
                                </td>
                                <td class="align-middle">
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
    </div>

    <!-- 2. カレンダー表示エリア（一覧と同じ col-md-10 で幅を統一） -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h2 class="h6 mb-0">期限カレンダー</h2>
                </div>
                <div class="card-body">
                    <!-- 高さの最大値を指定して、大きすぎないように制限 -->
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'ja',
      height: 'auto',
      contentHeight: 450,
      handleWindowResize: true,
      events: [
        @foreach($tasks as $task)
        @if($task->due_date)
        {
          title: '{{ $task->title }}',
          start: '{{ $task->due_date }}',
          url: '/tasks/{{ $task->id }}',
          @php
            // カレンダー用の色判定ロジック
            $hexColor = '#6c757d'; // デフォルト（灰色 / secondary）

            if (!$task->is_completed) {
                $dueDate = \Carbon\Carbon::parse($task->due_date);
                $now = \Carbon\Carbon::now()->startOfDay();
                $diffDays = $now->diffInDays($dueDate, false);

                if ($diffDays <= 3) {
                    $hexColor = '#dc3545'; // 赤 (danger)
                } elseif ($diffDays <= 7) {
                    $hexColor = '#ffc107'; // 黄 (warning)
                } elseif ($diffDays >= 30) {
                    $hexColor = '#198754'; // 緑 (success)
                } else {
                    $hexColor = '#0dcaf0'; // 水色 (info)
                }
            } else {
                $hexColor = '#adb5bd'; // 完了済みは薄いグレー
            }
          @endphp
          color: '{{ $hexColor }}',
          // 黄色の時は文字を黒にする（見やすくするため）
          textColor: '{{ $hexColor === "#ffc107" ? "#000" : "#fff" }}'
        },
        @endif
        @endforeach
      ]
    });
    calendar.render();
  });
</script>

</body>
</html>