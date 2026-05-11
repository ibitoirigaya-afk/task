<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスクダッシュボード</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <style>
        /* 完了済みタスクのスタイル */
        .completed { 
            text-decoration: line-through; 
            color: #adb5bd; 
            background-color: #f8f9fa !important; 
        }
        /* 左側の一覧エリアの高さ固定とスクロール設定 */
        .table-container { 
            height: 85vh; 
            overflow-y: auto; 
            background: white; 
            border-radius: 0 0 10px 10px; 
        }
        /* カレンダーの高さ固定 */
        .fc { 
            background: white; 
            padding: 15px; 
            border-radius: 10px; 
            height: 85vh; 
        }
        /* 状態バッジの微調整 */
        .badge-status { 
            font-size: 0.75rem; 
            font-weight: bold; 
            padding: 0.4em 0.7em;
            border-radius: 50px; /* 丸みのあるデザイン */
        }
        /* テーブルのセル内の縦位置を中央に */
        .table td { vertical-align: middle; }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid py-4">
    <div class="row">
        <!-- 左側：タスク一覧 (幅 5/12) -->
        <div class="col-lg-5 px-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h1 class="h5 mb-0">タスク一覧</h1>
                    <a href="/tasks/create" class="btn btn-light btn-sm fw-bold">＋ 新規作成</a>
                </div>
                <div class="table-container">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 45px;" class="text-center">完了</th>
                                <th>内容 / 状態</th>
                                <th style="width: 90px;" class="text-center">期限</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                            @php
                                // --- 色判定ロジック（一覧・バッジ・カレンダーで共通） ---
                                $color = '#6c757d'; // デフォルト：グレー
                                if (!$task->is_completed) {
                                    if ($task->due_date) {
                                        $diff = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($task->due_date), false);
                                        if($diff <= 3) $color = '#dc3545';      // 赤
                                        elseif($diff <= 7) $color = '#ffc107';  // 黄
                                        elseif($diff >= 30) $color = '#198754'; // 緑
                                        else $color = '#0dcaf0';                // 水色
                                    }
                                } else {
                                    $color = '#adb5bd'; // 完了済み：薄いグレー
                                }
                                
                                // 文字色の判定（黄色背景の時だけ黒文字にする）
                                $textColor = ($color === '#ffc107') ? '#000' : '#fff';
                            @endphp
                            <tr class="{{ $task->is_completed ? 'completed' : '' }}">
                                <td class="text-center">
                                    <form action="/tasks/{{ $task->id }}/toggle" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="checkbox" class="form-check-input" onChange="this.form.submit()" {{ $task->is_completed ? 'checked' : '' }}>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!-- タイトル -->
                                        <a href="/tasks/{{ $task->id }}" class="text-dark fw-bold text-decoration-none">
                                            {{ $task->title }}
                                        </a>
                                        <!-- 状態バッジ（期限と同じ色を適用） -->
                                        <span class="badge ms-2 badge-status shadow-sm" 
                                              style="background-color: {{ $color }}; color: {{ $textColor }}; border: none;">
                                            {{ $task->status ?: '未入力' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span style="color: {{ $color }}; font-weight: bold; font-size: 0.85rem;">
                                        {{ $task->due_date ? date('m/d', strtotime($task->due_date)) : '-' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 右側：カレンダー (幅 7/12) -->
        <div class="col-lg-7 px-3">
            <div id='calendar' class="shadow-sm border-0"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ja',
        height: '100%',
        handleWindowResize: true,
        events: [
            @foreach($tasks as $task)
            @if($task->due_date)
            {
                title: '{{ $task->title }}',
                start: '{{ $task->due_date }}',
                url: '/tasks/{{ $task->id }}',
                @php
                    // カレンダーの色も同様のロジックで算出
                    $hex = '#6c757d';
                    if (!$task->is_completed) {
                        $diff = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($task->due_date), false);
                        if($diff <= 3) $hex = '#dc3545';
                        elseif($diff <= 7) $hex = '#ffc107';
                        elseif($diff >= 30) $hex = '#198754';
                        else $hex = '#0dcaf0';
                    } else { $hex = '#adb5bd'; }
                @endphp
                color: '{{ $hex }}',
                textColor: '{{ $hex == "#ffc107" ? "#000" : "#fff" }}'
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