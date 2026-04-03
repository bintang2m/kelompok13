<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Novel Baru</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('writer.novels.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Judul Novel</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Sinopsis</label>
                        <textarea name="description" rows="5" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Cover Image</label>
                        <input type="file" name="cover" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    
                    <div class="mb-4 bg-gray-50 p-4 rounded border border-gray-200">
                        <label class="block text-gray-700 font-bold mb-3 border-b-2 border-blue-200 pb-1 inline-block">Kategori Genre <span class="text-xs font-normal text-gray-500 ml-2">(Pilih yang sesuai)</span></label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            @forelse($genres as $genre)
                                <label class="flex items-center space-x-2 bg-white p-2 border border-gray-100 rounded shadow-sm hover:bg-blue-50 cursor-pointer transition">
                                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $genre->name }}</span>
                                </label>
                            @empty
                                <div class="col-span-full text-sm text-yellow-600">Belum ada genre yang dibuat oleh admin.</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="mb-4 flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Status Penulisan</label>
                            <select name="status" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="ongoing">Ongoing (Sedang Berjalan)</option>
                                <option value="completed">Completed (Selesai)</option>
                                <option value="hiatus">Hiatus</option>
                            </select>
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Status Publikasi</label>
                            <select name="publish_status" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="draft">Draft (Sembunyikan)</option>
                                <option value="published">Published (Terbitkan ke Publik)</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Jika ditetapkan sebagai 'Published', novel ini akan otomatis muncul di Home.</p>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('writer.novels.index') }}" class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-900">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Novel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>