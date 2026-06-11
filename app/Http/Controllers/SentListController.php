<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;

class SentListController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $currentTab = $request->query('tab', 'news-tab');

        $newsItems = News::where('user_id', $userId)
            ->latest()
            ->paginate(10, ['*'], 'news_page')
            ->appends(['tab' => 'news-tab']); // ページを切り替えてもタブを維持

        $posts = Post::where('user_id', $userId)
            ->latest()
            ->paginate(10, ['*'], 'post_page')
            ->appends(['tab' => 'post-tab']);

        return view('sent.index', compact('currentTab', 'newsItems', 'posts'));
    }
}
