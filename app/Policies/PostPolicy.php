<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy
{
    public function update(User $user, Post $post) :bool
    {
        return $user->id === $post->user_id; // 書き方１
    }

    public function delete(User $user, Post $post) :bool
    {
        return $user->is($post->user); // 書き方２
    }

    public function before(User $user, string $ability) :?bool
    {
        if($user->is_admin) {
            return true;
        }

        return null;
    }
}
