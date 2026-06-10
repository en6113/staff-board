<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'file_path',
        'type',
        'expires_at',
    ];

    public function Users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('is_read', 'is_hidden');
    }
}
