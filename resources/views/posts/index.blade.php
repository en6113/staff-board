<x-app-layout>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">掲示・回覧一覧</h1>
                <a href="{{ route('posts.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded shadow-sm transition">
                    + 新規作成
                </a>
            </div>

            <div class="flex space-x-4 mb-4 border-b">
                <a href="{{ route('posts.index', ['tab' => 'all']) }}"
                    class="py-2 px-4 {{ $currentTab === 'all' ? 'border-b-2 border-blue-500 text-blue-600 font-bold' : 'text-gray-500' }}">
                    すべて
                </a>
            
                <a href="{{ route('posts.index', ['tab' => 'hidden']) }}"
                    class="py-2 px-4 {{ $currentTab === 'hidden' ? 'border-b-2 border-blue-500 text-blue-600 font-bold' : 'text-gray-500' }}">
                    非表示中
                </a>
            </div>

            @if($posts->isEmpty())
                <p class="text-gray-500 py-4">掲示・回覧はありません。</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    区分</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    タイトル</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    添付ファイル</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    掲載期限</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    操作</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($posts as $post)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->type === 'circular' ? 'bg-purple-100 text-purple-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $post->type === 'circular' ? '回覧' : '掲示' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('posts.show', $post->id) }}"
                                            class="text-sm font-medium text-green-600 hover:underline block truncate max-w-md">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        {{-- 非表示中タブのときは「再表示」ボタンを表示 --}}
                                        @if($currentTab === 'hidden')
                                            <form action="{{ route('posts.unhide', $post->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH') 
                                                <button type="submit" class="text-blue-600 hover:text-blue-900 cursor-pointer">再表示</button>
                                            </form>
                                        @else

                                            {{-- 非表示ボタン（例：既読状態であれば非表示にできる仕様） --}}
                                            @if(!$post->is_unread)
                                                <form action="{{ route('posts.hide', $post->id) }}" method="POST" class="inline-block"
                                                    onsubmit="return confirm('この掲示・回覧を一覧から非表示にしますか？');">
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
                    {{ $posts->appends(['tab' => $currentTab])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

</x-app-layout>