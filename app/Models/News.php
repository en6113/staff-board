<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'priority',
    ];

    // お知らせの投稿者を取得する
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // お知らせの確認状況を取得する
    public function Users() :BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('is_read', 'is_hidden');
    }
}
