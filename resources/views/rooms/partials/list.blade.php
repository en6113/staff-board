{{--
チャット一覧カード（共通部品）
使い方: @include('rooms.partials.list', ['rooms' => $rooms])
--}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4 border-b pb-2">
        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
            <span class="w-2 h-6 bg-purple-600 rounded-full"></span>
            チャット
        </h2>
        {{-- 幅が狭いので「+」だけのボタンにする --}}
        <a href="{{ route('rooms.create') }}" aria-label="グループを作成" title="グループを作成"
            class="inline-flex items-center justify-center w-8 h-8 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition shrink-0">
            <span class="text-lg leading-none">&plus;</span>
        </a>
    </div>

    @if($rooms->isEmpty())
        <p class="text-gray-500 text-sm py-4">まだトークルームがありません。</p>
    @else
        <ul class="divide-y divide-gray-200 lg:max-h-[60vh] lg:overflow-y-auto">
            @foreach($rooms as $room)
                <li>
                    <a href="{{ route('rooms.show', $room) }}" class="block px-2 py-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="flex items-center gap-2 mb-1">
                            {{-- 区分（グループ or 個人） --}}
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium shrink-0
                                        {{ $room->type === 'group' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-700' }}">
                                {{ $room->type === 'group' ? 'グループ' : '個人' }}
                            </span>
                            <span class="text-xs text-gray-400 ml-auto shrink-0">
                                {{ $room->updated_at->format('n/j H:i') }}
                            </span>
                        </div>
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ $room->displayName() }}
                            @if($room->type === 'group')
                                <span class="text-gray-400 font-normal">（{{ $room->users->count() }}人）</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>