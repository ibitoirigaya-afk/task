<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * 一括代入（Mass Assignment）を許可する属性
     * JavaのEntityでいう、セッターやコンストラクタで一括設定できるフィールドの定義です。
     */
    protected $fillable = [
        'title',
        'description',
        'is_completed', // チェック状態
        'due_date',     // 期限
    ];
}