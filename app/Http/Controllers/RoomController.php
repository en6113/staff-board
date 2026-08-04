<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Http\Request;


class RoomController extends Controller
{
    /**
     * トークルーム一覧
     */
    public function index(Request $request)
    {
        $rooms = $request->user()->rooms()
            ->with('users')
            ->latest('rooms.updated_at')
            ->get();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * トークルーム作成画面表示
     */
    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->orderBy('name')->get();

        return view('rooms.create', compact('users'));
    }

    /**
     * トークルーム新規作成
     */
    public function store(StoreRoomRequest $request)
    {
        $validated = $request->validated();

        $room = Room::createGroup($validated['name'], $request->user(), $validated['member_ids']);

        return redirect(route('rooms.show', $room));
    }

    /**
     * トークルーム詳細
     */
    public function show(Room $room)
    {
        abort_unless($room->users->contains(auth()->id()), 403);

        $messages = $room->messages()->with('user')->orderBy('id')->get();

        return view('rooms.show', compact('room', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
}
