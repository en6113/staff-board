<x-app-layout>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- ホーム画面と同じ部品を読み込むだけ --}}
            @include('rooms.partials.list', ['rooms' => $rooms])

        </div>
    </div>

</x-app-layout>