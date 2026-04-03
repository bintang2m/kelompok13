<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 border-b border-gray-300 pb-4">
                <h1 class="text-3xl font-extrabold text-[#1f305f]">
                    @if(request('search'))
                        Hasil Pencarian: "{{ request('search') }}"
                    @else
                        {{ $title }}
                    @endif
                </h1>
                
                <div class="mt-4 md:mt-0 flex gap-4">
                    <form action="{{ route('novels.index') }}" method="GET" class="flex gap-2">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <select name="sort" onchange="this.form.submit()" class="border-gray-200 rounded-md shadow-sm text-sm focus:ring focus:ring-blue-200">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Sortir: Terbaru</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Sortir: Paling Populer</option>
                            <option value="all" {{ request('sort') == 'all' ? 'selected' : '' }}>Sortir: Abjad (A-Z)</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-12">
                @forelse($novels as $novel)
                    <x-novel-card :novel="$novel" />
                @empty
                    <div class="col-span-full text-center py-20">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <h3 class="text-xl font-bold text-gray-500">Tidak ada novel</h3>
                        <p class="text-gray-400 mt-2">Belum ada karya yang cocok dengan pencarian atau rentang filter ini.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8 flex justify-center">
                {{ $novels->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
