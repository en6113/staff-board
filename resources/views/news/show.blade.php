<x-app-layout>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">

            {{-- メタ情報（ヘッダー部分） --}}
            <div class="border-b pb-4 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium shrink-0 {{ $news->priority->colorClass() }}">
                        {{ $news->priority->label() }}
                    </span>

                    <span class="text-xs text-gray-500">
                        投稿日: {{ $news->created_at->format('Y/m/d H:i') }}
                    </span>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 leading-tight">
                    {{ $news->title }}
                </h1>

                <p class="text-xs text-gray-400 mt-2">
                    投稿者: {{ $news->user->name ?? '不明' }}
                </p>
            </div>

            {{-- 本文 --}}
            <div class="text-gray-800 text-sm leading-relaxed whitespace-pre-wrap min-h-[200px] bg-gray-50 p-4 rounded border border-gray-100">{{ $news->content }}</div>

            {{-- フッター・操作ボタン --}}
            <div class="flex justify-between items-center mt-8 pt-4 border-t">
                <a href="{{ url()->previous() }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded transition text-sm">
                    &larr; 戻る
                </a>
            </div>

        </div>
    </div>
</div>

</x-app-layout>