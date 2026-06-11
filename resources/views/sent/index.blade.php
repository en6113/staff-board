<x-app-layout>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">送信一覧</h1>
                </div>

                <div class="flex space-x-4 mb-4 border-b">
                    <a href="{{ route('sent.index', ['tab' => 'news-tab']) }}"
                        class="py-2 px-4 {{ $currentTab === 'news-tab' ? 'border-b-2 border-blue-500 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                        送信済みお知らせ
                    </a>

                    <a href="{{ route('sent.index', ['tab' => 'post-tab']) }}"
                        class="py-2 px-4 {{ $currentTab === 'post-tab' ? 'border-b-2 border-blue-500 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                        送信済み掲示・回覧
                    </a>
                </div>

                <div class="tab-content">
                    <div id="news-tab" class="{{ $currentTab === 'news-tab' ? 'block' : 'hidden' }}">
                        @if($newsItems->isEmpty())
                            <p class="text-gray-500 py-4">送信済のお知らせはありません。</p>
                        @else
                            <div class="overflow-x-auto mb-4">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                タイトル</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                優先度</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                投稿日時</th>
                                            <th
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium shrink-0 {{ $news->priority->colorClass() }}">
                                                        {{ $news->priority->label() }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $news->created_at->format('Y/m/d H:i') }}
                                                </td>
                                                <td class="flex justify-end px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                    @if(auth()->id() === $news->user_id)
                                                        <a href="{{ route('news.edit', $news->id) }}"
                                                            class="text-amber-600 hover:text-amber-900 mr-2">編集</a>
                                                        <form action="{{ route('news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('この掲示・回覧を本当に削除しますか？')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-amber-900 mr-2">削除</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $newsItems->links() }}
                            </div>
                        @endif
                    </div>

                    <div id="post-tab" class="{{ $currentTab === 'post-tab' ? 'block' : 'hidden' }}">
                        @if($posts->isEmpty())
                            <p class="text-gray-500 py-4">送信済の掲示・回覧はありません。</p>
                        @else
                            <div class="overflow-x-auto mb-4">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                区分</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                タイトル</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                添付ファイル</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                掲載期限</th>
                                            <th
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                操作</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($posts as $post)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium shrink-0 {{ $post->type->colorClass() }}">
                                                        {{ $post->type->label() }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <a href="{{ route('posts.show', $post->id) }}"
                                                        class="text-sm font-medium text-gray-800 hover:underline block truncate max-w-md">
                                                        {{ $post->title }}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if($post->file_path)
                                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">あり</span>
                                                    @else
                                                        <span class="text-xs text-gray-400">なし</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $post->expires_at ? \Carbon\Carbon::parse($post->expires_at)->format('Y/m/d H:i') : '未設定' }}
                                                </td>
                                                <td class="flex justify-end px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                    @if(auth()->id() === $post->user_id)
                                                        <a href="{{ route('posts.edit', $post->id) }}" class="text-amber-600 hover:text-amber-900 mr-2">編集</a>
                                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('この掲示・回覧を本当に削除しますか？')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-amber-900 mr-2">削除</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>