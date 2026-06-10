<x-app-layout>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">

            {{-- メタ情報（ヘッダー部分） --}}
            <div class="border-b pb-4 mb-6">
                <div class="flex items-center space-x-2 mb-2">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->type === 'circular' ? 'bg-purple-100 text-purple-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $post->type === 'circular' ? '回覧' : '掲示' }}
                    </span>

                    <span class="text-xs text-gray-500">
                        投稿日: {{ $post->created_at->format('Y/m/d') }}
                    </span>

                    @if($post->expires_at)
                        <span
                            class="text-xs {{ \Carbon\Carbon::parse($post->expires_at)->isPast() ? 'text-red-500 font-bold' : 'text-gray-400' }}">
                            （期限: {{ \Carbon\Carbon::parse($post->expires_at)->format('Y/m/d H:i') }} まで）
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl font-bold text-gray-900 leading-tight">
                    {{ $post->title }}
                </h1>

                <p class="text-xs text-gray-400 mt-2">
                    投稿者: {{ $post->user->name ?? '不明' }}
                </p>
            </div>

            {{-- 添付ファイルセクション --}}
            <div class="bg-gray-50 p-6 rounded-lg border border-dashed border-gray-300 text-center">
                @if($post->file_path)
                    <div class="flex flex-col items-center space-y-3">
                        {{-- クリップアイコン --}}
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                            </path>
                        </svg>
                        <div class="text-sm text-gray-700 font-medium">
                            添付ファイルがあります
                        </div>
                        {{-- ※Storageへのシンボリックリンク（asset）を想定 --}}
                        <a href="{{ asset('storage/' . $post->file_path) }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center px-4 py-2 border border-green-600 text-sm font-medium rounded-md text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                            ファイルをダウンロード / 確認する
                        </a>
                    </div>
                @else
                    <p class="text-sm text-gray-400">この掲示・回覧に添付ファイルはありません。</p>
                @endif
            </div>

            {{-- フッター・操作ボタン --}}
            <div class="flex justify-between items-center mt-8 pt-4 border-t">
                <a href="{{ route('posts.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded transition text-sm">
                    &larr; 一覧に戻る
                </a>

                <div class="flex space-x-2">
                    {{-- 非表示ボタン --}}
                    <form action="{{ route('posts.hide', $post->id) }}" method="POST"
                        onsubmit="return confirm('この掲示・回覧を非表示にしますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-600 font-medium py-2 px-4 rounded transition text-sm">
                            この情報を非表示にする
                        </button>
                    </form>

                    {{-- 投稿者本人の場合は編集ボタンを表示 --}}
                    @if(auth()->id() === $post->user_id)
                        <a href="{{ route('posts.edit', $post->id) }}"
                            class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded shadow-sm transition text-sm">
                            編集する
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

</x-app-layout>