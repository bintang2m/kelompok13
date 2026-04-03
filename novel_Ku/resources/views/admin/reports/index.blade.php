<x-app-layout>
    <div class="space-y-6">
        <div class="flex items-center gap-3 mb-6 border-b-2 border-red-500 pb-2 inline-block">
            <h2 class="text-3xl font-extrabold text-gray-900">Keluhan & Laporan Komunitas</h2>
            <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full font-bold shadow-sm">Tiket Isu</span>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelapor</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Karya Bermasalah</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keluhan Detail</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Eksekusi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reports as $report)
                        <tr class="hover:bg-red-50 transition items-start">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report->created_at->format('d M Y - H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700">{{ $report->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($report->novel)
                                    <span class="font-bold text-gray-900 block">{{ $report->novel->title }}</span>
                                    <span class="text-[10px] bg-red-100 text-red-800 px-1 py-0.5 rounded">ID: {{ $report->novel->id }}</span>
                                @else
                                    <span class="text-gray-400 italic">Karya telah terhapus</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-sm">
                                <span class="bg-yellow-50 text-yellow-800 p-2 block rounded border border-yellow-100 shadow-inner">
                                    "{{ $report->reason }}"
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex flex-col gap-2 items-end">
                                    @if($report->novel)
                                        <a href="{{ route('novels.show', $report->novel) }}" target="_blank" class="text-blue-600 hover:underline font-bold text-xs">Cek Ke TKP →</a>
                                    @endif
                                    <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Selesaikan/hapus kasus laporan ini dari pelacakan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-emerald-600 hover:text-white font-bold px-3 py-1 bg-emerald-50 hover:bg-emerald-600 border border-emerald-200 rounded text-xs transition">Selesaikan</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">Situasi aman. Tidak ada laporan keluhan dari pengguna saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
