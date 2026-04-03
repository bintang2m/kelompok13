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
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4">Total Views</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chapters as $chapter)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-semibold">{{ $chapter->chapter_number }}</td>
                            <td class="p-4">{{ $chapter->title }}</td>
                            <td class="p-4 text-center">
                                @if($chapter->publish_status === 'published')
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded shadow-sm font-bold">Publis</span>
                                @else
                                    <span class="bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded shadow-sm font-bold">Draft</span>
                                @endif
                            </td>
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
                        <tr><td colspan="5" class="p-6 text-center text-gray-500">Belum ada bab yang dirilis.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>