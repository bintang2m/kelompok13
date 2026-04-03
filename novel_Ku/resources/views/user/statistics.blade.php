<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <h2 class="text-3xl font-extrabold text-[#1f305f] border-b-2 border-blue-600 pb-2 mb-8 inline-block">Statistik Aktivitas</h2>
            
            <!-- Statistik Sebagai Penulis -->
            <section class="bg-white overflow-hidden shadow-md sm:rounded-2xl p-8 border border-gray-100 relative">
                <div class="absolute top-0 left-0 w-2 h-full bg-blue-600"></div>
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Kinerja Penulis Terukur
                </h3>
                
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">
                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100 flex flex-col items-center justify-center text-center shadow-inner">
                        <span class="text-4xl font-extrabold text-blue-700 mb-1">{{ number_format($writerStats['total_novels']) }}</span>
                        <span class="text-xs font-semibold text-blue-900 uppercase tracking-wide">Total Novel Dibuat</span>
                    </div>

                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100 flex flex-col items-center justify-center text-center shadow-inner">
                        <span class="text-4xl font-extrabold text-blue-700 mb-1">{{ number_format($writerStats['published_novels']) }}</span>
                        <span class="text-xs font-semibold text-blue-900 uppercase tracking-wide">Novel Publikasi</span>
                    </div>
                    
                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100 flex flex-col items-center justify-center text-center shadow-inner">
                        <span class="text-4xl font-extrabold text-blue-700 mb-1">{{ number_format($writerStats['total_chapters']) }}</span>
                        <span class="text-xs font-semibold text-blue-900 uppercase tracking-wide">Bab Dirilis</span>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-200 flex flex-col items-center justify-center text-center shadow-inner">
                        <span class="text-4xl font-extrabold text-green-700 mb-1">{{ number_format($writerStats['total_novel_views']) }}</span>
                        <span class="text-xs font-semibold text-green-900 uppercase tracking-wide">Kunjungan/Views</span>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-5 border border-yellow-200 flex flex-col items-center justify-center text-center shadow-inner">
                        <span class="text-4xl font-extrabold text-yellow-600 mb-1">{{ number_format($writerStats['average_rating'], 1) }}</span>
                        <span class="text-xs font-semibold text-yellow-900 uppercase tracking-wide">Rataan Bintang</span>
                    </div>
                </div>
            </section>

            <!-- Statistik Sebagai Pembaca -->
            <section class="bg-white overflow-hidden shadow-md sm:rounded-2xl p-8 border border-gray-100 relative">
                <div class="absolute top-0 left-0 w-2 h-full bg-purple-500"></div>
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Aktivitas Pembaca
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-purple-50 rounded-xl p-6 border border-purple-100 flex items-center gap-6 shadow-sm">
                        <div class="bg-white p-4 rounded-2xl shadow border border-purple-50 text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-purple-900 mb-1 uppercase tracking-wide">Interaksi Diskusi</p>
                            <span class="text-3xl font-extrabold text-purple-700">{{ number_format($readerStats['total_comments']) }} <span class="text-sm font-semibold">Terkirim</span></span>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 rounded-xl p-6 border border-purple-100 flex items-center gap-6 shadow-sm">
                        <div class="bg-white p-4 rounded-2xl shadow border border-purple-50 text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-purple-900 mb-1 uppercase tracking-wide">Koleksi Bacaan</p>
                            <span class="text-3xl font-extrabold text-purple-700">{{ number_format($readerStats['total_bookmarks']) }} <span class="text-sm font-semibold">Tersimpan</span></span>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 rounded-xl p-6 border border-purple-100 flex items-center gap-6 shadow-sm">
                        <div class="bg-white p-4 rounded-2xl shadow border border-purple-50 text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-purple-900 mb-1 uppercase tracking-wide">Apresiasi Penulis</p>
                            <span class="text-3xl font-extrabold text-purple-700">{{ number_format($readerStats['total_reviews']) }} <span class="text-sm font-semibold">Ternilai</span></span>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
