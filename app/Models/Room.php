<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'direct_key', 'created_by'];

    /**
     * このモデルが属するユーザー
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('last_read_at');
    }

    /**
     * このモデルに紐づくメッセージ
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public static function findOrCreateDirect(User $me, User $partner): self
    {
        $ids = [$me->id, $partner->id];
        sort($ids);
        $key = implode('-', $ids);

        return DB::transaction(function () use ($key, $ids) {
            $room = self::where('direct_key', $key)->first();
            if ($room)
                return $room;

            $room = self::create(['type' => 'direct', 'direct_key' => $key, 'created_by' => $ids[0]]);
            $room->users()->attach($ids);
            return $room;
        });
    }

    public static function createGroup(string $name, User $owner, array $memberIds): self
    {
        return DB::transaction(function () use ($name, $owner, $memberIds) {
            $room = self::create(['type' => 'group', 'name' => $name, 'created_by' => $owner->id]);
            $room->users()->attach(array_unique([...$memberIds, $owner->id]));
            return $room;
        });
    }

    public function displayName(): string
    {
        if ($this->type === 'group')
            return $this->name;
        return $this->users->firstWhere('id', '!=', auth()->id())?->name ?? '(退職者)';
    }
}

