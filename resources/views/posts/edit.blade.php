<x-app-layout>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">掲示・回覧 編集</h1>

            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">区分</label>
                    <select name="type" id="type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach(\App\Enums\PostType::cases() as $type)
                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $post->title) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700">添付ファイル（変更する場合のみ選択）</label>
                    @if($post->file_path)
                        <p class="text-xs text-gray-500 mb-1">現在のファイル: {{ ($post->file_name) }}</p>
                    @endif
                    <input type="file" name="file_path" id="file_path"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    @error('file_path') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700">掲載期限</label>
                    <input type="datetime-local" name="expires_at" id="expires_at"
                        value="{{ old('expires_at', $post->expires_at ? \Carbon\Carbon::parse($post->expires_at)->format('Y-m-d\TH:i') : '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    @error('expires_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <a href="{{ route('posts.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded transition">
                        キャンセル
                    </a>
                    @if(auth()->id() === $post->user_id)
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded shadow-sm transition">
                            更新
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

</x-app-layout>