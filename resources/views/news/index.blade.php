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

            @if($newsItems->isEmpty())
                <p class="text-gray-500 py-4">お知らせはありません。</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    状態</th>
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $news->is_unread ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $news->is_unread ? '未読' : '既読' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('news.show', $news->id) }}"
                                            class="text-sm font-medium text-blue-600 hover:underline block truncate max-w-md">
                                            {{ $news->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-700">{{ $news->priority }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $news->created_at->format('Y/m/d H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        {{-- 編集ボタン（投稿者または管理者用） --}}
                                        @if(auth()->id() === $news->user_id)
                                            <a href="{{ route('news.edit', $news->id) }}"
                                                class="text-amber-600 hover:text-amber-900 mr-2">編集</a>
                                        @endif

                                        {{-- 既読の場合のみ非表示ボタンを表示 --}}
                                        @if(!$news->is_unread)
                                            <form action="{{ route('news.hide', $news->id) }}" method="POST" class="inline-block"
                                                onsubmit="return confirm('このお知らせを一覧から非表示にしますか？');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500">非表示</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- ページネーション --}}
                <div class="mt-4">
                    {{ $newsItems->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

</x-app-layout>