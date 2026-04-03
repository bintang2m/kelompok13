<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-2">Novel Tersimpan</h2>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @forelse($bookmarks as $bookmark)
                        @if($bookmark->novel)
                            <x-novel-card :novel="$bookmark->novel" />
                        @endif
                    @empty
                        <div class="col-span-full py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            <p>Belum ada novel yang Anda simpan. Mulai jelajahi dan simpan novel favorit Anda!</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-8">
                    {{ $bookmarks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
