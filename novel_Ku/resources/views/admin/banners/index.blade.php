<x-app-layout>
    <div class="space-y-6">
        <h2 class="text-3xl font-extrabold text-gray-900 border-b-2 border-red-500 pb-2 mb-6 inline-block">Konfigurasi Banner Utama (Home)</h2>

        @if (session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-xl p-6 border border-gray-100 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Unggah Gambar Banner Baru</h3>
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Pilih File Gambar (Resolusi lebar disarankan HD)</label>
                        <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 border border-gray-200 rounded p-1" required>
                        <p class="text-xs text-gray-500 mt-1">Maks. 5MB (JPG/PNG). Gambar akan ditaruh rata kanan pada layar utama.</p>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Sub-Judul Emas (Label Kecil atas)</label>
                        <input type="text" name="subtitle" class="w-full border-gray-300 rounded shadow-sm focus:border-red-500" placeholder="Misal: REKOMENDASI MINGGU INI">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Teks Judul Besar (Headline)</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded shadow-sm focus:border-red-500" placeholder="Misal: BACA NOVEL EPIK TERBARU">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Teks Tombol Aksi</label>
                        <input type="text" name="button_text" class="w-full border-gray-300 rounded shadow-sm focus:border-red-500" placeholder="Misal: BACA SEKARANG">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Tautan (URL Redirect saat di-klik)</label>
                        <input type="text" name="link" class="w-full border-gray-300 rounded shadow-sm focus:border-red-500" placeholder="Misal: /novels/1">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Urutan Tampil (Paling kecil tampil duluan)</label>
                        <input type="number" name="order" value="0" class="w-full border-gray-300 rounded shadow-sm focus:border-red-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-bold mb-2">Teks Deskripsi (Opsional)</label>
                        <textarea name="description" rows="2" class="w-full border-gray-300 rounded shadow-sm focus:border-red-500" placeholder="Biarkan kosong jika banner dirancang hanya menampilkan gambar saja."></textarea>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-bold rounded shadow hover:bg-red-700 transition">Unggah ke Server & Aktifkan Slider</button>
                </div>
            </form>
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-red-500 pl-3">Daftar Banner Berjalan</h3>
        <div class="bg-gray-100 p-4 rounded-xl shadow-inner border border-gray-200">
            <div class="grid grid-cols-1 gap-6">
                @forelse($banners as $banner)
                <div class="bg-white rounded-lg p-4 shadow-sm flex items-center justify-between border border-gray-200 hover:border-red-300 transition relative overflow-hidden">
                    <div class="absolute inset-y-0 left-0 w-2 bg-gradient-to-b from-red-400 to-red-600"></div>
                    <div class="flex items-center gap-6 pl-4">
                        <img src="{{ Storage::url($banner->image) }}" class="w-40 h-24 object-cover rounded shadow border">
                        <div>
                            <p class="text-xs uppercase font-bold text-red-500 mb-1">Urutan: #{{ $banner->order }}</p>
                            <h4 class="font-extrabold text-xl text-gray-900">{{ $banner->title ?? 'Tanpa Judul (Hanya Visual Banner)' }}</h4>
                            @if($banner->link)
                                <a href="{{ $banner->link }}" target="_blank" class="text-sm text-blue-600 hover:underline mt-1 inline-block">{{ $banner->link }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="pr-4">
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini dari slider halaman pertama Anda?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 font-bold rounded shadow-sm transition">Copot Banner</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    Belum ada satupun Banner. Halaman Home saat ini akan memakai format Fallback kosong.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
