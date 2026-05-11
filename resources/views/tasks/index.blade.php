<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスクダッシュボード</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <style>
        body { background-color: #f4f7f6; }
        .completed { text-decoration: line-through; color: #adb5bd; background-color: #fafafa !important; }
        
        /* 基本のカードスタイル */
        .dashboard-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            border: none;
        }

        /* --- レスポンシブ制御 --- */
        
        /* PCサイズ (992px以上) */
        @media (min-width: 992px) {
            .scroll-area {
                height: 85vh;
                overflow-y: auto;
            }
            #calendar-container {
                height: 85vh;
            }
        }

        /* スマホ・タブレットサイズ (992px未満) */
        @media (max-width: 991.98px) {
            .scroll-area {
                height: auto; /* スクロールさせず全表示 */
            }
            #calendar-container {
                height: auto;
                min-height: 600px; /* カレンダーが潰れないよう最低高さを確保 */
            }
        }

        .badge-status { 
            font-size: 0.75rem; 
            font-weight: bold; 
            border-radius: 50px; 
            padding: 0.4em 0.8em;
        }
        .table td { vertical-align: middle; }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <div class="row">
        <!-- 左側：タスク一覧 -->
        <div class="col-lg-5 px-3">
            <div class="card dashboard-card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center border-0 py-3">
                    <h1 class="h5 mb-0 fw-bold">タスク一覧</h1>
                    <a href="/tasks/create" class="btn btn-light btn-sm fw-bold shadow-sm">＋ 新規作成</a>
                </div>
                <div class="scroll-area">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;" class="text-center">完了</th>
                                <th>内容 / 状態</th>
                                <th style="width: 80px;" class="text-center">期限</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                            @php
                                $color = '#6c757d';
                                if (!$task->is_completed) {
                                    if ($task->due_date) {
                                        $diff = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($task->due_date), false);
                                        if($diff <= 3) $color = '#dc3545';
                                        elseif($diff <= 7) $color = '#ffc107';
                                        elseif($diff >= 30) $color = '#198754';
                                        else $color = '#0dcaf0';
                                    }
                                } else { $color = '#adb5bd'; }
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
                                        <a href="/tasks/{{ $task->id }}" class="text-dark fw-bold text-decoration-none">
                                            {{ $task->title }}
                                        </a>
                                        <span class="badge ms-2 badge-status" style="background-color: {{ $color }}; color: {{ $textColor }};">
                                            {{ $task->status ?: '未入力' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span style="color: {{ $color }}; font-weight: bold; font-size: 0.8rem;">
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

        <!-- 右側：カレンダー -->
        <div class="col-lg-7 px-3">
            <div class="card dashboard-card p-3">
                <div id='calendar-container'>
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
        height: 'auto', // 親要素の高さに依存させず、コンテンツに合わせる
        handleWindowResize: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        events: [
            @foreach($tasks as $task)
            @if($task->due_date)
            {
                title: '{{ $task->title }}',
                start: '{{ $task->due_date }}',
                url: '/tasks/{{ $task->id }}',
                @php
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