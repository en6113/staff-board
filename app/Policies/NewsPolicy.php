<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NewsPolicy
{
    public function update(User $user, News $news): bool
    {
        return $user->id === $news->user_id;
    }

    public function delete(User $user, News $news): bool
    {
        return $user->is($news->user);
    }

    // 管理者はすべての認可をパスする
    public function before(User $user, string $ability): ?bool
    {
        if ($user->is_admin) {
            return true;
        }

        return null;
    }
}
