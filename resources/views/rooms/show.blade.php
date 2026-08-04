<x-app-layout>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ========================================================= --}}
            {{-- ルーム名ヘッダー --}}
            {{-- ========================================================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2 min-w-0">
                        <span class="w-2 h-6 bg-purple-600 rounded-full shrink-0"></span>
                        <span class="truncate">{{ $room->displayName() }}</span>
                        @if($room->type === 'group')
                            <span class="text-sm font-normal text-gray-400 shrink-0">{{ $room->users->count() }}人</span>
                        @endif
                    </h2>
                    <a href="{{ route('rooms.index') }}"
                        class="text-sm font-medium text-purple-600 hover:text-purple-800 hover:underline flex items-center gap-1 shrink-0">
                        <span>&larr;</span> チャット一覧
                    </a>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- メッセージ（吹き出し） --}}
            {{-- ========================================================= --}}
            <div class="space-y-4 px-2">
                @php $prevDate = null; @endphp

                @forelse($messages as $message)
                            @php
                                $date = $message->created_at->format('Y/n/j');
                                $isSelf = $message->user_id === auth()->id();
                            @endphp

                            {{-- 日付が変わったら区切りを入れる --}}
                            @if($date !== $prevDate)
                                <div class="flex justify-center py-2">
                                    <span class="px-3 py-1 rounded-full bg-gray-200 text-gray-600 text-xs font-medium">
                                        {{ $date }}
                                    </span>
                                </div>
                                @php $prevDate = $date; @endphp
                            @endif

                            <div class="flex {{ $isSelf ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[75%] min-w-0">
                                    {{-- 相手のメッセージだけ送信者名を出す --}}
                                    @unless($isSelf)
                                        <p class="text-xs text-gray-500 mb-1 ml-1">{{ $message->user->name }}</p>
                                    @endunless

                                    <div class="px-4 py-2.5 text-sm whitespace-pre-wrap break-words shadow-sm
                                        {{ $isSelf
                    ? 'bg-purple-600 text-white rounded-2xl rounded-br-sm'
                    : 'bg-white text-gray-800 border border-gray-200 rounded-2xl rounded-bl-sm' }}">
                                        {{ $message->body }}
                                    </div>

                                    <p class="text-xs text-gray-400 mt-1 {{ $isSelf ? 'text-right mr-1' : 'ml-1' }}">
                                        {{ $message->created_at->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-8">まだメッセージがありません。</p>
                @endforelse
            </div>

            {{-- ========================================================= --}}
            {{-- 送信フォーム --}}
            {{-- ========================================================= --}}
            <form method="POST" action="{{ route('messages.store', $room) }}"
                class="sticky bottom-4 bg-white shadow-md sm:rounded-lg p-4 flex items-end gap-3">
                @csrf
                <textarea name="body" rows="2" required placeholder="メッセージを入力"
                    class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm resize-none">{{ old('body') }}</textarea>
                <button type="submit"
                    class="px-5 py-2.5 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition shrink-0">
                    送信
                </button>
            </form>

        </div>
    </div>

    {{-- 開いたとき最新のメッセージが見えるよう一番下までスクロールする --}}
    <script>
        window.scrollTo(0, document.body.scrollHeight);
    </script>

</x-app-layout>