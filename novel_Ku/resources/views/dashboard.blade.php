<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Dasbor Utama ({{ $user->name }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Profil Banner Dasar -->
            <div class="bg-gray-900 border border-gray-800 shadow-xl sm:rounded-2xl overflow-hidden p-8 relative flex flex-col items-center gap-4 text-center">
                <!-- Aksen Cahaya Latar Belakang -->
                <div class="absolute inset-0 bg-blue-600/10 blur-3xl rounded-full z-0 pointer-events-none transform scale-150"></div>

                <!-- Avatar Bulat (Berdasarkan Permintaan: Di atas) -->
                <div class="w-40 h-40 md:w-48 md:h-48 flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-700 rounded-full flex items-center justify-center shadow-[0_0_40px_rgba(59,130,246,0.6)] border-2 border-blue-400/30 relative z-10 mb-2 overflow-hidden">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-6xl md:text-8xl font-black text-white drop-shadow-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                
                <!-- Teks dan Identitas (Berdasarkan Permintaan: Di bawah avatar berturut-turut) -->
                <div class="text-white relative z-10 flex-col flex items-center w-full max-w-2xl px-4">
                    <h1 class="text-4xl lg:text-5xl font-extrabold mb-1 tracking-tight">{{ $user->name }}</h1>
                    <p class="text-gray-400 font-medium text-lg mb-6">{{ $user->email }}</p>

                    <!-- Baris Atribut & Lencana -->
                    <div class="flex flex-wrap gap-3 items-center justify-center mb-6">
                        <span class="bg-gray-800/80 px-4 py-1.5 rounded-full border border-gray-700 backdrop-blur-sm text-sm"><i class="fas fa-calendar-alt mr-1 text-gray-500"></i> Bergabung {{ $user->created_at->format('d M Y') }}</span>
                        @if($user->role === 'admin')
                            <span class="bg-red-500/10 text-red-400 px-4 py-1.5 rounded-full border border-red-500/20 font-bold text-sm">🛡️ Administrator</span>
                        @else
                            <span class="bg-blue-500/10 text-blue-400 px-4 py-1.5 rounded-full border border-blue-500/20 font-bold text-sm">✍️ Pengguna/Penulis</span>
                        @endif
                    </div>
                    
                    <!-- Bio Section -->
                    @if($user->bio)
                        <div class="bg-gray-800/40 p-5 rounded-2xl border border-gray-700/50 mt-2 w-full shadow-inner">
                            <p class="text-gray-300 md:text-lg leading-relaxed italic">"{{ $user->bio }}"</p>
                        </div>
                    @else
                        <div class="mt-2 text-sm text-gray-400 bg-gray-800/20 py-2 px-6 rounded-full border border-gray-700/30 hover:border-blue-500/50 transition">
                            <a href="{{ route('profile.edit') }}" class="hover:text-blue-400 transition">📝 Tulis sesuatu tentang dirimu (Bio)...</a>
                        </div>
                    @endif

                    <!-- Tombol Edit Terpisah agar lebih rapi -->
                    <a href="{{ route('profile.edit') }}" class="mt-8 px-8 py-2.5 bg-white text-gray-900 font-bold rounded-full hover:bg-gray-200 transition shadow-lg transform hover:scale-105 active:scale-95 flex items-center gap-2">
                        <span>⚙️ Kelola Akun Profil</span>
                    </a>
                </div>
            </div>

            <!-- Kartu Info Pintasan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tahanan Pembaca -->
                <a href="{{ route('bookmarks.index') }}" class="bg-white p-6 sm:rounded-xl shadow-sm border-l-4 border-blue-500 flex flex-col hover:shadow-md transition">
                    <span class="text-sm font-bold text-gray-500 uppercase">Perpustakaan Tersimpan</span>
                    <span class="text-4xl font-black text-gray-900 mt-2">{{ $bookmarksCount }}</span>
                    <span class="text-blue-600 text-sm mt-3 font-semibold">Lihat rak →</span>
                </a>

                <!-- Riwayat -->
                <a href="{{ route('history.index') }}" class="bg-white p-6 sm:rounded-xl shadow-sm border-l-4 border-green-500 flex flex-col hover:shadow-md transition">
                    <span class="text-sm font-bold text-gray-500 uppercase">Riwayat Bacaan</span>
                    <span class="text-4xl font-black text-gray-900 mt-2">📖</span>
                    <span class="text-green-600 text-sm mt-3 font-semibold">Lanjut membaca →</span>
                </a>

                <!-- Pemberitahuan -->
                <a href="{{ route('inbox.index') }}" class="bg-white p-6 sm:rounded-xl shadow-sm border-l-4 border-red-500 flex flex-col hover:shadow-md transition">
                    <span class="text-sm font-bold text-gray-500 uppercase">Kotak Masuk (Notifikasi)</span>
                    <span class="text-4xl font-black text-gray-900 mt-2 lg:text-3xl">Pesan/Isu & Alerts</span>
                    <span class="text-red-600 text-sm mt-3 font-semibold">Buka kotak pesan →</span>
                </a>
            </div>

            <!-- Area Penulis (Jika memiliki novel) -->
            <div class="bg-white shadow-sm sm:rounded-xl p-6 border border-gray-100 mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 border-l-4 border-gray-800 pl-3">Panel Penulis Saya</h3>
                    <a href="{{ route('writer.novels.index') }}" class="text-sm font-bold bg-gray-100 text-gray-700 px-4 py-2 hover:bg-gray-200 rounded transition">Kelola Semua Novel</a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 border border-gray-100 p-4 rounded text-center">
                        <span class="block text-2xl font-black text-gray-800">{{ $totalNovels }}</span>
                        <span class="text-xs text-gray-500 font-semibold">KARYA DIBUAT</span>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 p-4 rounded text-center">
                        <span class="block text-2xl font-black text-gray-800">{{ number_format($totalViews) }}</span>
                        <span class="text-xs text-gray-500 font-semibold">TOTAL VIEWS</span>
                    </div>
                </div>

                @if($recentNovels->count() > 0)
                    <p class="font-semibold text-gray-700 mb-3 text-sm">Update Karya Terakhir</p>
                    <div class="space-y-3">
                        @foreach($recentNovels as $novel)
                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded border border-gray-100">
                                <span class="font-bold text-gray-800">{{ $novel->title }}</span>
                                <span class="text-xs font-semibold px-2 py-1 rounded {{ $novel->publish_status === 'published' ? 'bg-blue-100 text-blue-800' : ($novel->publish_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-200 text-gray-800') }}">
                                    {{ strtoupper($novel->publish_status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-gray-400 bg-gray-50 rounded border border-dashed border-gray-300">
                        Belum ada karya. Menulis karya pertama Anda merubah segalanya!
                        <a href="{{ route('writer.novels.create') }}" class="block text-blue-600 font-semibold hover:underline mt-2">Mulai Menulis →</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
