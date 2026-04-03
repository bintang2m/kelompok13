<x-app-layout>
    <!-- Alpine Slider for Featured Novels -->
    <div x-data="{ activeSlide: 0, slides: {{ max($banners->count(), 1) }}, timer: null }" 
         x-init="timer = setInterval(() => { activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1 }, 4000)" 
         @mouseenter="clearInterval(timer)" 
         @mouseleave="timer = setInterval(() => { activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1 }, 4000)"
         class="bg-[#1a1b1e] text-white py-16 relative overflow-hidden rounded-b-[40px] shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="flex transition-transform duration-700 ease-in-out" :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                @forelse($banners as $index => $banner)
                <div class="w-full flex-shrink-0 flex items-center justify-between px-12 gap-8 relative rounded-2xl overflow-hidden aspect-[21/9]">
                    <!-- Background Image (Dimmed) -->
                    <div class="absolute inset-0 bg-cover bg-center z-0 opacity-40 mix-blend-overlay border border-gray-700 rounded-2xl" style="background-image: url('{{ Storage::url($banner->image) }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/80 to-transparent z-0 rounded-2xl"></div>

                    <div class="w-full md:w-3/4 relative z-10 p-8 md:p-12">
                        @if($banner->subtitle)
                             <p class="text-xs font-bold uppercase tracking-widest mb-3 text-red-500 bg-red-500/10 inline-block px-3 py-1 rounded-full border border-red-500/20">{{ $banner->subtitle }}</p>
                        @endif
                        
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 leading-tight text-white drop-shadow-xl">{{ $banner->title ?? '' }}</h1>
                        
                        @if($banner->description)
                            <p class="text-gray-300 mb-8 max-w-2xl text-base md:text-lg drop-shadow">{{ $banner->description }}</p>
                        @endif

                        @if($banner->link)
                            <a href="{{ url($banner->link) }}" class="inline-block px-8 py-3 bg-red-600 text-white font-bold rounded-full shadow-lg shadow-red-600/30 hover:bg-red-500 transform hover:-translate-y-1 transition">{{ $banner->button_text ?? 'BACA SEKARANG' }}</a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="w-full flex-shrink-0 flex items-center justify-between px-12 gap-8">
                    <div class="w-1/2">
                        <p class="text-xs font-semibold uppercase tracking-wider mb-2 text-gray-400">Selamat datang di Platform Cerita</p>
                        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight uppercase text-white">Mulai Menulis & Membaca Novel Hebat</h1>
                        <p class="text-gray-400 mb-6 line-clamp-3 text-base">Platform terbaik bagi Penulis dan Pembaca fiksi. Sebarkan ceritamu ke seluruh dunia!</p>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-red-600 text-white font-bold rounded shadow hover:bg-red-700">BERGABUNG SEKARANG</a>
                    </div>
                    <div class="w-1/2 flex justify-center">
                        <div class="w-64 h-80 bg-gray-800 rounded-xl flex flex-col items-center justify-center text-gray-500 border-2 border-dashed border-gray-600 shadow-2xl">
                            <svg class="w-20 h-20 mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Slider Controls -->
            <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" class="absolute left-0 top-1/2 transform -translate-y-1/2 -ml-2 text-gray-800 hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" class="absolute right-0 top-1/2 transform -translate-y-1/2 -mr-2 text-gray-800 hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Dots -->
            <div class="absolute bottom-[-1rem] left-1/2 transform -translate-x-1/2 flex space-x-2">
                <template x-for="i in slides" :key="i">
                    <button @click="activeSlide = i - 1" :class="{'bg-gray-800 w-6': activeSlide === i - 1, 'bg-white w-3': activeSlide !== i - 1}" class="h-3 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>
    </div>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            
            <!-- POPULER SECTION -->
            <section>
                <div class="flex justify-between items-baseline mb-6 border-b pb-2">
                    <h2 class="text-xl font-bold text-[#1f305f]">Populer</h2>
                    <a href="{{ route('novels.index', ['sort' => 'popular']) }}" class="text-xs font-semibold text-gray-600 hover:text-blue-600">Semua ></a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    @forelse($popularNovels as $novel)
                        <x-novel-card :novel="$novel" />
                    @empty
                        <p class="text-gray-500 col-span-4 text-center">Belum ada novel tersedia.</p>
                    @endforelse
                </div>
            </section>

            <!-- TERBARU SECTION -->
            <section>
                <div class="flex justify-between items-baseline mb-6 border-b pb-2">
                    <h2 class="text-xl font-bold text-[#1f305f]">Terbaru</h2>
                    <a href="{{ route('novels.index', ['sort' => 'latest']) }}" class="text-xs font-semibold text-gray-600 hover:text-blue-600">Semua ></a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    @forelse($latestNovels as $novel)
                        <x-novel-card :novel="$novel" />
                    @empty
                        <p class="text-gray-500 col-span-4 text-center">Belum ada novel tersedia.</p>
                    @endforelse
                </div>
            </section>

            <!-- SEMUA SECTION -->
            <section>
                <div class="flex justify-between items-baseline mb-6 border-b pb-2">
                    <h2 class="text-xl font-bold text-[#1f305f]">Semua</h2>
                    <a href="{{ route('novels.index', ['sort' => 'all']) }}" class="text-xs font-semibold text-gray-600 hover:text-blue-600">Semua ></a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
                    @forelse($allNovels as $novel)
                        <x-novel-card :novel="$novel" />
                    @empty
                        <p class="text-gray-500 col-span-4 text-center">Belum ada novel tersedia.</p>
                    @endforelse
                </div>
                <div>
                    {{ $allNovels->links() }}
                </div>
            </section>

        </div>
    </div>
    
    <!-- Footer from Wireframe -->
    <footer class="bg-[#d2dbe5] border-t border-gray-300 py-12 text-sm text-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-extrabold text-2xl text-gray-900 mb-4 tracking-tighter">Noctale.</h3>
                <p class="mb-4">Website platform novel digital yang menghubungkan penulis dan pembaca secara interaktif.</p>
                <div class="flex space-x-2">
                    <a href="#" class="w-8 h-8 rounded-full bg-white flex items-center justify-center hover:bg-gray-300 shadow-sm font-bold text-gray-700">f</a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white flex items-center justify-center hover:bg-gray-300 shadow-sm font-bold text-gray-700">t</a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white flex items-center justify-center hover:bg-gray-300 shadow-sm font-bold text-gray-700">ig</a>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">About</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:underline">About Noctale</a></li>
                    <li><a href="#" class="hover:underline">Contact</a></li>
                    <li><a href="#" class="hover:underline">Partnership</a></li>
                    <li><a href="#" class="hover:underline">Business Relation</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Community</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:underline">Comic</a></li>
                    <li><a href="#" class="hover:underline">Blog</a></li>
                    <li><a href="#" class="hover:underline">Podcast</a></li>
                    <li><a href="#" class="hover:underline">Invite a Friend</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Socials</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:underline">Discord</a></li>
                    <li><a href="#" class="hover:underline">Instagram</a></li>
                    <li><a href="#" class="hover:underline">Twitter</a></li>
                    <li><a href="#" class="hover:underline">Facebook</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-gray-400/50 flex flex-col md:flex-row justify-between text-xs items-center">
            <p>&copy; 2026 Noctale. All rights reserved.</p>
            <div class="space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Terms & Conditions</a>
            </div>
        </div>
    </footer>
</x-app-layout>