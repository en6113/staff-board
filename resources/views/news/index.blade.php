<x-app-layout>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">お知らせ一覧</h1>
                <a href="{{ route('news.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow-sm transition">
                    + 新規作成
                </a>
            </div>

            <div class="flex space-x-4 mb-4 border-b">
                <a href="{{ route('news.index', ['tab' => 'all']) }}"
                    class="py-2 px-4 {{ $currentTab === 'all' ? 'border-b-2 border-blue-500 text-blue-600 font-bold' : 'text-gray-500' }}">
                    すべて
                </a>
            
                <a href="{{ route('news.index', ['tab' => 'hidden']) }}"
                    class="py-2 px-4 {{ $currentTab === 'hidden' ? 'border-b-2 border-blue-500 text-blue-600 font-bold' : 'text-gray-500' }}">
                    非表示中
                </a>
            </div>

            @if($newsItems->isEmpty())
                <p class="text-gray-500 py-4">お知らせはありません。</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    タイトル</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    優先度</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    投稿日時</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    操作</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($newsItems as $news)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('news.show', $news->id) }}"
                                            class="text-sm font-medium block truncate max-w-md hover:underline {{ $news->is_read_by_user ? 'text-gray-400' : 'text-blue-600 font-bold'}}">
                                            {{ $news->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-700">{{ $news->priority?->label() ?? '未設定' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $news->created_at->format('Y/m/d H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        {{-- 編集ボタン（投稿者または管理者用） --}}
                                        @if(auth()->id() === $news->user_id)
                                            <a href="{{ route('news.edit', $news->id) }}"
                                                class="text-amber-600 hover:text-amber-900 mr-2">編集</a>
                                            <form action="{{ route('news.destroy', $news->id) }}" method="POST" class="inline" onsubmit="return confirm('本当に削除しますか？');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 mr-2 cursor-pointer">削除</button>
                                            </form>
                                        @endif

                                        {{-- 非表示中タブのときは「再表示」ボタンを表示 --}}
                                        @if($currentTab === 'hidden')
                                            <form action="{{ route('news.unhide', $news->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH') 
                                                <button type="submit" class="text-blue-600 hover:text-blue-900 cursor-pointer">再表示</button>
                                            </form>
                                        @else
                                            {{-- 通常時（すべて）のときは、既読の場合のみ非表示ボタンを表示 --}}
                                            @if(!$news->is_unread)
                                                <form action="{{ route('news.hide', $news->id) }}" method="POST" class="inline-block"
                                                    onsubmit="return confirm('このお知らせを一覧から非表示にしますか？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-500">非表示</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- ページネーション --}}
                <div class="mt-4">
                    {{ $newsItems->appends(['tab' => $currentTab])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

</x-app-layout>