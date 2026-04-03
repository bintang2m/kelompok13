<x-app-layout>
    <div class="space-y-6">
        <h2 class="text-3xl font-extrabold text-gray-900 border-b-2 border-red-500 pb-2 mb-6 inline-block">Manajemen Karya (Approval)</h2>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Pending Approval Section -->
        <div class="bg-yellow-50 border border-yellow-200 shadow-md rounded-xl p-6 mb-8 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-32 h-32 bg-yellow-400 opacity-10 rounded-full -mr-10 -mt-10 blur-xl"></div>
            
            <h3 class="text-xl font-bold text-yellow-800 mb-4 flex items-center gap-2">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                </span>
                Menunggu Persetujuan Publikasi ({{ $pendingNovels->count() }})
            </h3>
            
            @if($pendingNovels->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($pendingNovels as $pending)
                        <div class="bg-white border border-yellow-300 rounded-lg p-4 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg line-clamp-1 border-b pb-1">{{ $pending->title }}</h4>
                                <p class="text-xs text-blue-600 mb-2 mt-1">📝 Penulis: {{ $pending->author->name }}</p>
                                <p class="text-xs text-gray-600 line-clamp-3 mb-4 leading-relaxed">{{ $pending->description }}</p>
                            </div>
                            <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                                <form action="{{ route('admin.novels.update', $pending) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="w-full py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded shadow-sm text-xs transition uppercase border border-emerald-600">Terima (Approve)</button>
                                </form>
                                <form action="{{ route('admin.novels.update', $pending) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="w-full py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded shadow-sm text-xs transition uppercase border border-red-600" onclick="return confirm('Tolak Publikasi novel ini?')">Tolak (Draft)</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 text-yellow-700 bg-yellow-100/50 rounded-lg border border-yellow-200 border-dashed">
                    Tidak ada novel baru yang menunggu izin perilisan. Anda bisa bersantai!
                </div>
            @endif
        </div>

        <!-- Published Novels Table -->
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-emerald-500 pl-3">Daftar Karya Aktif Beredar</h3>
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Karya</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Akun Kreator</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Skala Novel</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Hukum Takedown</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($publishedNovels as $published)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 border-l-4 border-emerald-400">{{ $published->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $published->author->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="bg-blue-50 text-blue-800 border border-blue-200 px-2 py-0.5 rounded text-[11px] font-bold">{{ strtoupper($published->status) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <form action="{{ route('admin.novels.destroy', $published) }}" method="POST" onsubmit="return confirm('Musnahkan novel ini secara absolut dan paksa? Tindakan ini tidak bisa dirubah.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-white font-bold px-3 py-1.5 bg-red-50 hover:bg-red-600 border border-red-200 rounded shadow-sm transition">Paksa Lenyap</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada karya yang dilepas ke ranah publik...</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $publishedNovels->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
