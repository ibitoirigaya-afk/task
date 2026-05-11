<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * 一括割当（Mass Assignment）を許可する属性
     * 
     * JavaのEntityでフィールドを定義する感覚に近いです。
     * ここに名前がない項目は、Task::create($request->all()) では保存されません。
     */
    protected $fillable = [
        'title',          // タスク名
        'description',    // 説明
        'due_date',       // 期限
        'is_completed',   // 完了フラグ
        'status',         // 状態（今回追加したカラム）
    ];

    /**
     * データの型変換（キャスト）
     * 
     * DBでは文字列や数値として保存されている値を、
     * PHP側で扱う際に自動で適切な型（Booleanなど）に変換します。
     */
    protected $casts = [
        'is_completed' => 'boolean',
    ];
}