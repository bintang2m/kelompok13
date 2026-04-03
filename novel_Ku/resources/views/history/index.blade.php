<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Bacaan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">Terakhir Anda Baca</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($histories as $history)
                        @if($history->novel)
                        <div class="flex border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition bg-white">
                            <div class="w-24 h-36 flex-shrink-0">
                                @if($history->novel->cover)
                                    <img src="{{ Storage::url($history->novel->cover) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-400">No Cover</div>
                                @endif
                            </div>
                            <div class="p-4 flex flex-col justify-center flex-1">
                                <a href="{{ route('novels.show', $history->novel) }}" class="font-bold text-gray-900 hover:text-blue-600 line-clamp-1 mb-1">{{ $history->novel->title }}</a>
                                <p class="text-xs text-gray-500 mb-2">Terakhir dibaca: {{ $history->last_read_at->diffForHumans() }}</p>
                                
                                <div class="mt-auto">
                                    <p class="text-[11px] text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded inline-block mb-2">Bab Terakhir: {{ $history->chapter->chapter_number ?? '?' }}</p>
                                    @if($history->chapter)
                                    <a href="{{ route('chapters.show', [$history->novel, $history->chapter]) }}" class="block text-center w-full px-3 py-1.5 bg-gray-900 text-white text-xs font-bold rounded shadow-sm hover:bg-gray-800 transition">
                                        Lanjutkan Baca
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="p-4 border border-red-200 bg-red-50 text-red-600 text-sm rounded-lg">Novel telah dihapus oleh penulis.</div>
                        @endif
                    @empty
                        <div class="col-span-full py-12 text-center text-gray-500 border-2 border-dashed border-gray-200 rounded-xl">
                            <span class="text-4xl block mb-2">📚</span>
                            <p>Anda belum memiliki riwayat membaca apapun.</p>
                            <a href="{{ route('home') }}" class="text-blue-600 hover:underline font-semibold mt-2 inline-block">Mulai jelajahi novel sekarang</a>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
