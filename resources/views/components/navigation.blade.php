<nav class="bg-gray-800 shadow-lg">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="flex justify-between items-center py-4">
            {{-- ロゴ --}}
            <a href="{{ route('home') }}" class="text-white text-xl font-bold hover:text-gray-300">
                📋 StaffBoard
            </a>

            {{-- ナビゲーションリンク --}}
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('news.create') }}" class="text-gray-300 hover:text-white">
                        お知らせ登録
                    </a>
                    <a href="{{ route('posts.create') }}" class="text-gray-300 hover:text-white">
                        掲示・回覧登録
                    </a>
                    <a href="{{ route('sent.index') }}" class="text-gray-300 hover:text-white">
                        送信一覧
                    </a>
                    <span class="text-gray-300">
                        {{ auth()->user()->name }}さん
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-white">
                            ログアウト
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">
                        ログイン
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-300 hover:text-white">
                        新規登録
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>