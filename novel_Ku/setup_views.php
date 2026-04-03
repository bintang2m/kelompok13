<?php
$base = __DIR__ . '/resources/views';

function makeDir($path) {
    if (!file_exists($path)) mkdir($path, 0777, true);
}

makeDir($base . '/novels');
makeDir($base . '/chapters');
makeDir($base . '/writer/novels');
makeDir($base . '/writer/chapters');

$views = [
    // 1. HOME VIEW
    'home.blade.php' => <<<'EOD'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Novel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($novels as $novel)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                        @if($novel->cover)
                            <img src="{{ Storage::url($novel->cover) }}" alt="Cover" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">No Cover</div>
                        @endif
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-2"><a href="{{ route('novels.show', $novel) }}" class="hover:text-blue-600">{{ $novel->title }}</a></h3>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $novel->description }}</p>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Oleh: {{ $novel->author->name }}</span>
                                <span>👀 {{ $novel->views }} views</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $novels->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
EOD,

    // 2. PUBLIC NOVEL SHOW
    'novels/show.blade.php' => <<<'EOD'
<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/3">
                    @if($novel->cover)
                        <img src="{{ Storage::url($novel->cover) }}" class="w-full rounded shadow">
                    @else
                        <div class="w-full aspect-[2/3] bg-gray-200 flex items-center justify-center text-gray-500 rounded">No Cover</div>
                    @endif
                </div>
                <div class="w-full md:w-2/3">
                    <h1 class="text-3xl font-bold mb-2">{{ $novel->title }}</h1>
                    <p class="text-gray-600 mb-4">Oleh {{ $novel->author->name }} &bull; {{ $novel->views }} Views</p>
                    <div class="mb-6 flex gap-2">
                        @foreach($novel->genres as $genre)
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $genre->name }}</span>
                        @endforeach
                    </div>
                    <h3 class="font-semibold text-lg border-b pb-2 mb-2">Sinopsis</h3>
                    <p class="text-gray-700 whitespace-pre-line mb-6">{{ $novel->description }}</p>
                    
                    <h3 class="font-semibold text-lg border-b pb-2 mb-2">Daftar Bab</h3>
                    <ul class="space-y-2">
                        @forelse($novel->chapters as $chapter)
                            <li>
                                <a href="{{ route('chapters.show', [$novel, $chapter]) }}" class="text-blue-600 hover:underline">
                                    Bab {{ $chapter->chapter_number }}: {{ $chapter->title }}
                                </a>
                            </li>
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada bab yang dipublikasikan.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
EOD,

    // 3. PUBLIC CHAPTER SHOW
    'chapters/show.blade.php' => <<<'EOD'
<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen border-t">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 text-center">
                <a href="{{ route('novels.show', $novel) }}" class="text-blue-600 hover:underline text-sm font-semibold uppercase tracking-wider">{{ $novel->title }}</a>
                <h1 class="text-3xl font-bold mt-2">Bab {{ $chapter->chapter_number }}: {{ $chapter->title }}</h1>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 font-serif text-lg leading-relaxed text-gray-800">
                {!! nl2br(e($chapter->content)) !!}
            </div>
            
            <div class="mt-8 flex justify-between">
                @if($prevChapter)
                    <a href="{{ route('chapters.show', [$novel, $prevChapter]) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">&larr; Bab Sebelumnya</a>
                @else
                    <div></div>
                @endif
                
                @if($nextChapter)
                    <a href="{{ route('chapters.show', [$novel, $nextChapter]) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Bab Selanjutnya &rarr;</a>
                @else
                    <div></div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
EOD,
    
    // 4. WRITER DASHBOARD INDEX
    'writer/novels/index.blade.php' => <<<'EOD'
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Karya Saya') }}</h2>
            <a href="{{ route('writer.novels.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">+ Buat Novel Baru</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="border border-gray-200 bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-4">Cover</th>
                        <th class="p-4">Judul</th>
                        <th class="p-4">Total Bab</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($novels as $novel)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 w-24">
                                @if($novel->cover)
                                    <img src="{{ Storage::url($novel->cover) }}" class="w-16 h-20 object-cover rounded shadow-sm">
                                @else
                                    <div class="w-16 h-20 bg-gray-200 text-xs text-center flex items-center justify-center">No Cover</div>
                                @endif
                            </td>
                            <td class="p-4 font-semibold">{{ $novel->title }}</td>
                            <td class="p-4">{{ $novel->chapters_count ?? 0 }} Bab</td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">{{ $novel->status }}</span>
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <a href="{{ route('writer.novels.chapters.index', $novel) }}" class="text-green-600 hover:underline font-semibold">Kelola Bab</a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('writer.novels.edit', $novel) }}" class="text-blue-600 hover:underline">Edit</a>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('writer.novels.destroy', $novel) }}" method="POST" class="inline" onsubmit="return confirm('Hapus novel ini beserta seluruh bab?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-6 text-center text-gray-500">Belum ada karya novel. Silakan buat yang baru.</td></tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="mt-4">{{ $novels->links() }}</div>
        </div>
    </div>
</x-app-layout>
EOD,
];

foreach($views as $path => $content) {
    file_put_contents($base . '/' . $path, $content);
}

echo "Views generated successfully\n";
?>
