<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6 bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Koleksi Karya Anda</h2>
                    <p class="text-gray-500 text-sm mt-1">Buat, terbitkan, dan kontrol semua riwayat novel Anda dari sini.</p>
                </div>
                <a href="{{ route('writer.novels.create') }}" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                    + Buat Novel Baru
                </a>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-4 border-b border-gray-200 flex space-x-6">
                <a href="{{ route('writer.novels.index', ['tab' => 'published']) }}" class="pb-2 text-sm font-bold {{ $tab === 'published' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                    Aktif / Publik ({{ $countPublished ?? 0 }})
                </a>
                <a href="{{ route('writer.novels.index', ['tab' => 'pending']) }}" class="pb-2 text-sm font-bold {{ $tab === 'pending' ? 'border-b-2 border-yellow-500 text-yellow-600' : 'text-gray-500 hover:text-gray-700' }}">
                    Menunggu Persetujuan ({{ $countPending ?? 0 }})
                </a>
                <a href="{{ route('writer.novels.index', ['tab' => 'draft']) }}" class="pb-2 text-sm font-bold {{ $tab === 'draft' ? 'border-b-2 border-gray-600 text-gray-800' : 'text-gray-500 hover:text-gray-700' }}">
                    Draft Disembunyikan ({{ $countDraft ?? 0 }})
                </a>
            </div>

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