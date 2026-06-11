<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $currentTab = $request->get('tab', 'all');

        if ($currentTab === 'hidden') {
            // 【非表示中タブ】
            $newsItems = News::whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('news_user.is_hidden', 1);
            })->with('users')->latest()->paginate(15);
        } else {
            // 【すべてタブ】非表示を除く
            $newsItems = News::whereDoesntHave('users', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('news_user.is_hidden', 1);
            })->with('users')->latest()->paginate(15);
        }

        return view('news.index', compact('newsItems', 'currentTab'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(NewsRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $news = News::create($validated);


        $news->users()->attach(auth()->id(), ['is_read' => 1]);

        return redirect()->route('home')->with('success', 'お知らせを登録しました。');
    }

    public function show(News $news)
    {
        $userId = auth()->id();
        // 中間テーブルが存在するか確認（存在すればtrue,なければfalseが返る）
        $hasPivot = $news->users()->where('user_id', $userId)->exists();

        if($hasPivot) {
            $news->users()->updateExistingPivot($userId, ['is_read' => 1]); //存在している場合はis_readを1に更新
        } else {
            $news->users()->attach($userId, ['is_read' => 1]); // 存在しない場合は新しくレコードを追加
        }

        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('news.edit',compact('news'));
    }

    public function update(NewsRequest $request, News $news)
    {
        $this->authorize('update', $news);
        $validated = $request->validated();
        $news->update($validated);

        return redirect()->route('home')->with('success', 'お知らせを更新しました。');
    }

    public function destroy(News $news)
    {
        $this->authorize('delete', $news);

        $news->delete();

        return redirect()->route('home')->with('success', 'お知らせを削除しました。');
    }

    // 非表示にする処理
    public function hide(News $news)
    {
        $news->users()->syncWithoutDetaching([
            auth()->id() => ['is_hidden' => 1]
        ]);

        return redirect()->route('news.index')->with('success', 'お知らせを非表示にしました。');
    }

    // 非表示にしたお知らせを再表示する処理
    public function unhide(News $news)
    {
        $userId = auth()->id();

        $news->users()->updateExistingPivot($userId, [
            'is_hidden' => 0
        ]);

        return redirect()->route('news.index', ['tab' => 'hidden'])->with('success', 'お知らせを再表示しました。');
    }
}
