<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Novel: {{ $novel->title }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('writer.novels.update', $novel) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Judul Novel</label>
                        <input type="text" name="title" value="{{ $novel->title }}" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Sinopsis</label>
                        <textarea name="description" rows="5" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>{{ $novel->description }}</textarea>
                    </div>
                    
                    <div class="mb-4 bg-gray-50 p-4 rounded border border-gray-200 flex items-center justify-between">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Ganti Cover Image</label>
                            <input type="file" name="cover" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        @if($novel->cover)
                            <div class="h-20 w-16 shadow-md border rounded overflow-hidden">
                                <img src="{{ Storage::url($novel->cover) }}" class="object-cover h-full w-full">
                            </div>
                        @endif
                    </div>

                    <div class="mb-4 bg-gray-50 p-4 rounded border border-gray-200">
                        <label class="block text-gray-700 font-bold mb-3 border-b-2 border-blue-200 pb-1 inline-block">Kategori Genre <span class="text-xs font-normal text-gray-500 ml-2">(Pilih yang sesuai)</span></label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            @forelse($genres as $genre)
                                <label class="flex items-center space-x-2 bg-white p-2 border border-gray-100 rounded shadow-sm hover:bg-blue-50 cursor-pointer transition">
                                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}" {{ $novel->genres->contains($genre->id) ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
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
                                <option value="ongoing" {{ $novel->status == 'ongoing' ? 'selected' : '' }}>Ongoing (Sedang Berjalan)</option>
                                <option value="completed" {{ $novel->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                                <option value="hiatus" {{ $novel->status == 'hiatus' ? 'selected' : '' }}>Hiatus</option>
                            </select>
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Status Publikasi</label>
                            <select name="publish_status" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="draft" {{ $novel->publish_status == 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                                <option value="published" {{ in_array($novel->publish_status, ['published', 'pending']) ? 'selected' : '' }}>Published (Terbitkan ke Publik)</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Jika ditetapkan sebagai 'Published' (dan berubah dari draf), karya akan menunggu persetujuan admin.</p>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('writer.novels.index') }}" class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-900 font-semibold">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded shadow hover:bg-blue-700">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
