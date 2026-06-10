<?php

namespace App\Models;

use App\Enums\NewsPriority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'priority',
    ];

    protected $casts = [
        'priority' => NewsPriority::class,
    ];

    // お知らせの投稿者を取得する
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // お知らせの確認状況(中間テーブル)を取得する
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'news_user')
            ->withPivot('is_read', 'is_hidden')
            ->withTimestamps();
    }

    /**
     * ログインユーザーが既読かどうかを判定するカスタム属性（is_read_by_user）
     */
    public function getIsReadByUserAttribute()
    {
        $userId = Auth::id();

        // ログインしているユーザーの中間テーブルのレコードを探す
        $userPivot = $this->users->where('id', $userId)->first();

        // レコードが存在しない、または is_read が 1 ではない（0など）場合は「未読(false)」
        if (!$userPivot || $userPivot->pivot->is_read !== 1) {
            return false;
        }

        // レコードが存在し、is_read が 1 の場合は「既読(true)」
        return true;
    }
}