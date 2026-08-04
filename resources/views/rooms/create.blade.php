<x-app-layout>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="w-2 h-6 bg-purple-600 rounded-full"></span>
                        グループを作成
                    </h2>
                    <a href="{{ route('rooms.index') }}"
                        class="text-sm font-medium text-purple-600 hover:text-purple-800 hover:underline flex items-center gap-1">
                        <span>&larr;</span> チャット一覧
                    </a>
                </div>

                {{-- バリデーションエラー --}}
                @if($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('rooms.store') }}" class="space-y-6">
                    @csrf

                    {{-- グループ名 --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            グループ名
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                    </div>

                    {{-- 参加メンバー --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            参加する職員
                        </label>
                        <div
                            class="max-h-72 overflow-y-auto rounded-lg border border-gray-300 divide-y divide-gray-100">
                            @foreach($users as $user)
                                <label
                                    class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition">
                                    <input type="checkbox" name="member_ids[]" value="{{ $user->id }}"
                                        @checked(in_array($user->id, old('member_ids', [])))
                                        class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-800">{{ $user->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-gray-500">作成者（自分）は自動的に参加します。</p>
                    </div>

                    <div class="pt-2 border-t">
                        <button type="submit"
                            class="px-5 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">
                            作成する
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</x-app-layout>