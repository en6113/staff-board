<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $currentTab = $request->get('tab', 'all');

        if ($currentTab === 'hidden') {
            // 【非表示中タブ】
            $posts = Post::whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('post_user.is_hidden', 1);
            })->with('users')->latest()->paginate(15);
        } else {
            // 【すべてタブ】非表示を除く
            $posts = Post::whereDoesntHave('users', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('post_user.is_hidden', 1);
            })->with('users')->latest()->paginate(15);
        }

        return view('posts.index', compact('posts', 'currentTab'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_path'] = $file->store('posts', 'public');
        }

        $post = Post::create($validated);

        $post->users()->attach(auth()->id(), ['is_read' => 1]);

        return redirect()->route('home')->with('success', '掲示・回覧を登録しました！');
    }

    public function show(Post $post)
    {
        $userId = auth()->id();

        // 中間テーブルがなければ作成、あればis_readを1にする
        $post->users()->syncWithoutDetaching([
            auth()->id() => ['is_read' => 1]
        ]);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post, PostRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $validated['file_name'] = $file->getClientOriginalName();

            if ($post->file_path) {
                Storage::disk('public')->delete($post->file_path); // 古いファイルを削除
            }
            $validated['file_path'] = $file->store('posts', 'public'); // 新しいファイルを保存
        } else {
            unset($validated['file_path']); // ファイルの変更がない場合は配列から除外
        }

        $post->update($validated);

        return redirect()->route('home')->with('success', '掲示・回覧を更新しました！');
    }

    public function destroy(Post $post)
    {
        if($post->file_path) {
            Storage::disk('public')->delete($post->file_path);
        }
        $post->delete();

        return redirect()->route('home')->with('success', '掲示・回覧を削除しました！');
    }

    public function hide(Post $post)
    {
        $post->users()->syncWithoutDetaching([
            auth()->id() => ['is_hidden' => 1]
        ]);

        return redirect()->route('posts.index')->with('success', '掲示・回覧を非表示にしました！');
    }

    public function unhide(Post $post)
    {
        $userId = auth()->id();

        $post->users()->updateExistingPivot($userId, [
            'is_hidden' => 0
        ]);

        return redirect()->route('posts.index', ['tab' => 'hidden'])->with('success', 'お知らせを再表示しました。');
    }
}
