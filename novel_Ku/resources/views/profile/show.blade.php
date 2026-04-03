<x-app-layout>
    <div class="bg-gray-900 border-b border-gray-800 relative overflow-hidden">
        <!-- Aksen Cahaya Latar Belakang -->
        <div class="absolute inset-x-0 top-0 h-96 bg-blue-600/10 blur-3xl rounded-full z-0 pointer-events-none transform scale-150 origin-top"></div>

        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col items-center text-center gap-4">
                <!-- Avatar -->
                <div class="w-40 h-40 md:w-48 md:h-48 flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-700 rounded-full flex items-center justify-center shadow-[0_0_40px_rgba(59,130,246,0.6)] border-2 border-blue-400/30 mb-2 overflow-hidden">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-6xl md:text-8xl font-black text-white drop-shadow-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                
                <!-- Profil Info -->
                <div class="text-white w-full max-w-2xl px-4 flex flex-col items-center">
                    <h1 class="text-4xl lg:text-5xl font-extrabold mb-1 tracking-tight">{{ $user->name }}</h1>
                    
                    <div class="flex flex-wrap justify-center gap-3 items-center text-sm font-medium mb-6 mt-4">
                        <span class="bg-gray-800/80 px-4 py-1.5 rounded-full border border-gray-700 text-gray-300"><i class="fas fa-calendar-alt text-gray-500 mr-1"></i> Bergabung {{ $user->created_at->format('M Y') }}</span>
                        @if($user->role === 'admin')
                            <span class="bg-red-500/10 text-red-400 px-4 py-1.5 rounded-full border border-red-500/20 font-bold shadow-sm shadow-red-500/10">🛡️ Administrator</span>
                        @else
                            <span class="bg-blue-500/10 text-blue-400 px-4 py-1.5 rounded-full border border-blue-500/20 font-bold shadow-sm shadow-blue-500/10">✍️ Penulis Konten</span>
                        @endif
                    </div>

                    @if($user->bio)
                        <div class="bg-gray-800/40 p-5 rounded-2xl border border-gray-700/50 mt-2 w-full shadow-inner mb-6">
                            <p class="text-gray-300 md:text-lg leading-relaxed italic">"{{ $user->bio }}"</p>
                        </div>
                    @endif
                    
                    <!-- Stats Bar -->
                    <div class="flex justify-center gap-8 md:gap-12 p-5 bg-gray-800/50 rounded-2xl w-full md:w-auto inline-flex border border-gray-700/50 shadow-lg">
                        <div class="text-center">
                            <span class="block text-4xl font-black text-white">{{ $totalNovels }}</span>
                            <span class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Karya Novel</span>
                        </div>
                        <div class="w-px bg-gray-600/50"></div>
                        <div class="text-center">
                            <span class="block text-4xl font-black text-white">{{ number_format($totalViews) }}</span>
                            <span class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Total Ditonton</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Karya List -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b-2 border-red-500 pb-2 inline-block">Rak Karya {{ $user->name }}</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @forelse($novels as $novel)
                <div class="group relative">
                    <a href="{{ route('novels.show', $novel) }}" class="block w-full overflow-hidden rounded-xl shadow-md bg-gray-900 aspect-[2/3] relative">
                        @if($novel->cover)
                            <img src="{{ Storage::url($novel->cover) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 group-hover:opacity-60">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500 bg-gray-200">No Cover</div>
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Hover Overlay Detail -->
                        <div class="absolute inset-x-0 bottom-0 p-3 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <span class="text-xs text-white bg-red-600 px-2 py-0.5 rounded shadow">{{ $novel->chapters_count ?? 0 }} Bab</span>
                            <p class="text-[10px] text-gray-300 mt-1 line-clamp-2">{{ $novel->description }}</p>
                        </div>
                    </a>
                    <h3 class="font-bold text-gray-800 mt-3 text-sm line-clamp-2 leading-snug group-hover:text-red-600 transition">{{ $novel->title }}</h3>
                </div>
            @empty
                <div class="col-span-full py-12 text-center border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50">
                    <p class="text-gray-500">Belum ada karya novel publik yang dirilis oleh pengguna ini.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $novels->links() }}
        </div>
    </div>
</x-app-layout>
