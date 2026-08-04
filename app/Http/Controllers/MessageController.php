<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    public function store(MessageRequest $request, Room $room)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $room->messages()->create($validated);
        $room->touch(); // updated_at更新

        return back();
    }
}
