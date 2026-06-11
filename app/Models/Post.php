<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'file_name',
        'file_path',
        'type',
        'expires_at',
    ];

    // 掲示・回覧の投稿者を取得する
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // 掲示・回覧の確認状況（中間テーブル）を取得する
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('is_read', 'is_hidden');
    }
}
