<x-app-layout>
    <div class="space-y-6">
        <h2 class="text-3xl font-extrabold text-gray-900 border-b-2 border-red-500 pb-2 mb-6 inline-block">Manajemen Kategori Genre</h2>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Form Card -->
            <div class="md:col-span-1">
                <div class="bg-white shadow rounded-xl p-6 border border-gray-100 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Tambah Genre Baru</h3>
                    <form action="{{ route('admin.genres.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Genre</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded shadow-sm focus:border-red-500 focus:ring focus:ring-red-200" placeholder="Misal: Fantasi, Horor, Romantis..." required autofocus>
                        </div>
                        <button type="submit" class="w-full py-2 bg-red-600 text-white font-bold rounded shadow hover:bg-red-700 transition">Tambahkan Kategori</button>
                    </form>
                </div>
            </div>
            
            <!-- Table Card -->
            <div class="md:col-span-2">
                <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Daftar Genre Aktif</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori Genre</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total Novel Tertaut</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi Singkirkan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($genres as $genre)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">#{{ $genre->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">{{ $genre->novels_count }} Karya</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus genre ini dari sistem? Semua novel yang menggunakan komposisi genre ini akan kehilangan label pencariannya!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-white font-bold px-3 py-1.5 bg-red-50 hover:bg-red-600 border border-red-200 rounded shadow-sm transition">Musnahkan</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-400">Anda belum membuat list genre apapun. Segera buat agar penulis dapat menamai karyanya.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $genres->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
