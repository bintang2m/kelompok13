<?php
$base = __DIR__ . '/resources/views';

$views = [
    // 5. NOVEL CREATE FORM
    'writer/novels/create.blade.php' => <<<'EOD'
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
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('writer.novels.index') }}" class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-900">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Novel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
EOD,

    // 6. CHAPTER INDEX
    'writer/chapters/index.blade.php' => <<<'EOD'
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Bab: {{ $novel->title }}</h2>
            <a href="{{ route('writer.novels.chapters.create', $novel) }}" class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">+ Tambah Bab Baru</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 border border-gray-200 bg-white rounded-lg shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-4">Bab Ke</th>
                        <th class="p-4">Judul Bab</th>
                        <th class="p-4">Total Views</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chapters as $chapter)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-semibold">{{ $chapter->chapter_number }}</td>
                            <td class="p-4">{{ $chapter->title }}</td>
                            <td class="p-4">{{ $chapter->views }} kali dibaca</td>
                            <td class="p-4 text-center space-x-2">
                                <a href="{{ route('writer.novels.chapters.edit', [$novel, $chapter]) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('writer.novels.chapters.destroy', [$novel, $chapter]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus bab ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-6 text-center text-gray-500">Belum ada bab yang dirilis.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
EOD,

    // 7. CHAPTER CREATE FORM
    'writer/chapters/create.blade.php' => <<<'EOD'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tulis Bab Baru: {{ $novel->title }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('writer.novels.chapters.store', $novel) }}" method="POST">
                    @csrf
                    <div class="mb-4 flex gap-4">
                        <div class="w-1/4">
                            <label class="block text-gray-700 font-bold mb-2">Bab Ke-</label>
                            <input type="number" name="chapter_number" value="{{ $nextNumber }}" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                        <div class="w-3/4">
                            <label class="block text-gray-700 font-bold mb-2">Judul Bab</label>
                            <input type="text" name="title" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Isi Bab</label>
                        <textarea name="content" rows="15" class="w-full border-gray-300 rounded shadow-sm font-serif focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Ketik isi novel Anda di sini..."></textarea>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('writer.novels.chapters.index', $novel) }}" class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-900">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Publikasikan Bab</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
EOD
];

foreach($views as $path => $content) {
    file_put_contents($base . '/' . $path, $content);
}

echo "Forms generated successfully\n";
?>
