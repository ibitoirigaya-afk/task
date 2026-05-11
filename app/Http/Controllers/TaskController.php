<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // 期限順に並び替え（期限なしは最後）
        $tasks = Task::orderByRaw('due_date IS NULL ASC')
                     ->orderBy('due_date', 'asc')
                     ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'nullable|max:100', // 追加
        ]);

        Task::create($request->all());

        return redirect('/tasks')->with('success', 'タスクが作成されました。');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function toggle(Task $task)
    {
        $task->update(['is_completed' => !$task->is_completed]);
        return back();
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return redirect('/tasks')->with('success', 'タスクを削除しました。');
    }
    public function updateStatus(Request $request, Task $task)
{
    $task->update([
        'status' => $request->status
    ]);

    return back()->with('success', '状態を更新しました！');
}
public function update(Request $request, Task $task)
{
    $request->validate([
        'title' => 'required|max:255',
        'status' => 'nullable|max:100',
        'due_date' => 'nullable|date',
        'description' => 'nullable',
    ]);

    // 全項目を更新
    $task->update($request->all());

    return redirect('/tasks')->with('success', 'タスクを更新しました！');
}
}