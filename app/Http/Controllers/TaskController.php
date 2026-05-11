<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 1. 入力画面を表示
    public function create()
    {
        return view('tasks.create');
    }

    // 2. 保存処理
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        Task::create($request->all());

        // 保存後は「一覧画面（/tasks）」に飛ばす
        return redirect('/tasks')->with('success', 'タスクが作成されました。');
    }

    // 3. 一覧を表示する（追加分）
public function index()
{
    // 1. 期限（due_date）が早い順（昇順：ASC）で取得
    // 2. ただし、期限が設定されていない（null）ものは最後に回す
    $tasks = Task::orderByRaw('due_date IS NULL ASC') // nullは後ろへ
                 ->orderBy('due_date', 'asc')         // 近い日付が上
                 ->get();

    return view('tasks.index', compact('tasks'));
}

    // 4. 削除する（追加分）
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect('/tasks')->with('success', 'タスクを削除しました。');
    }
public function toggle(Task $task)
{
    $task->update([
        'is_completed' => !$task->is_completed
    ]);
    return back(); // 前の画面に戻る
}
public function show(Task $task)
{
    return view('tasks.show', compact('task'));
}
} // <--- 必ず最後にこの「クラスを閉じるカッコ」があることを確認！