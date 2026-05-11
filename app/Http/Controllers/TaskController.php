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
        $tasks = Task::all(); 
        return view('tasks.index', compact('tasks'));
    }

    // 4. 削除する（追加分）
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect('/tasks')->with('success', 'タスクを削除しました。');
    }
} // <--- 必ず最後にこの「クラスを閉じるカッコ」があることを確認！