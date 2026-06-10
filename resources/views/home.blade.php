<x-app-layout>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        {{-- ========================================================= --}}
        {{-- お知らせ（News）ブロック --}}
        {{-- ========================================================= --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                    最新のお知らせ
                </h2>
                <a href="{{ route('news.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                    お知らせ一覧 <span>&rarr;</span>
                </a>
            </div>

            @if($newsItems->isEmpty())
                <p class="text-gray-500 text-sm py-4">新着のお知らせはありません。</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($newsItems as $news)
                        <li class="py-3 flex justify-between items-center hover:bg-gray-50 px-2 rounded-lg transition" id="news-item-{{ $news->id }}">
                            <div class="flex items-center space-x-3 min-w-0 flex-1">
                                {{-- 未読・既読バッジ --}}
                                @if($news->is_unread) {{-- ※未読判定のロジック（例: $news->users()->where('user_id', auth()->id())->exists() の否定など） --}}
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 shrink-0">
                                        未読
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 shrink-0">
                                        既読
                                    </span>
                                @endif

                                {{-- タイトルと日時 --}}
                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between gap-4">
                                    <a href="{{ route('news.show', $news->id) }}" class="block text-sm font-medium text-gray-900 hover:text-blue-600 truncate">
                                        {{ $news->title }}
                                    </a>
                                    <span class="block text-xs text-gray-400 shrink-0 mt-1 sm:mt-0">
                                        {{ $news->created_at->format('Y/m/d H:i') }}
                                    </span>
                                </div>
                            </div>

                            {{-- 既読の場合のみ削除（非表示）ボタンを表示 --}}
                            @if(!$news->is_unread)
                                <div class="ml-4 shrink-0">
                                    <form action="{{ route('news.hide', $news->id) }}" method="POST" onsubmit="return confirm('このお知らせをホーム画面から非表示にしますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-gray-400 hover:text-red-500 border border-gray-200 hover:border-red-200 rounded px-2 py-1 transition bg-white shadow-sm">
                                            非表示
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- ========================================================= --}}
        {{-- 掲示・回覧（Post）ブロック --}}
        {{-- ========================================================= --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-6 bg-green-600 rounded-full"></span>
                    掲示・回覧板
                </h2>
                <a href="{{ route('posts.index') }}" class="text-sm font-medium text-green-600 hover:text-green-800 hover:underline flex items-center gap-1">
                    掲示・回覧一覧 <span>&rarr;</span>
                </a>
            </div>

            @if($posts->isEmpty())
                <p class="text-gray-500 text-sm py-4">現在、掲示・回覧はありません。</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($posts as $post)
                        <li class="py-3 flex justify-between items-center hover:bg-gray-50 px-2 rounded-lg transition">
                            <div class="flex items-center space-x-3 min-w-0 flex-1">
                                {{-- 区分（掲示 or 回覧）バッジの例 --}}
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->type === 'circular' ? 'bg-purple-100 text-purple-800' : 'bg-amber-100 text-amber-800' }} shrink-0">
                                    {{ $post->type === 'circular' ? '回覧' : '掲示' }}
                                </span>

                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between gap-4">
                                    <a href="{{ route('posts.show', $post->id) }}" class="block text-sm font-medium text-gray-900 hover:text-green-600 truncate">
                                        {{ $post->title }}
                                    </a>
                                    <span class="block text-xs text-gray-400 shrink-0 mt-1 sm:mt-0">
                                        {{ $post->created_at->format('Y/m/d') }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
</div>

</x-app-layout>