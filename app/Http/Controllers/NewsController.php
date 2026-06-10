<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\NewsRequest;

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = News::latest()->paginate(20);

        return view('news.index', compact('newsItems'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(NewsRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        News::create($validated);

        return redirect()->route('home')->with('success', 'お知らせを登録しました。');
    }

    public function show(News $news)
    {
        $pivot = $news->users()->syncWithoutDetaching([
            auth()->id() => ['is_read' => true]
        ]);

        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('news.edit',compact('news'));
    }

    public function update(NewsRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $request->update($validated);

        return redirect()->route('home')->with('success', 'お知らせを更新しました。');
    }

    public function destroy(News $news)
    {
        $this->authorize('delete', $news);

        $news->delete();

        return redirect()->route('home')->with('success', 'お知らせを削除しました。');
    }
}
