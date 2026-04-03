<x-app-layout>
    <div class="space-y-6">
        <h2 class="text-3xl font-extrabold text-gray-900 border-b-2 border-red-500 pb-2 mb-6 inline-block">Monitor Keseluruhan Sistem</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow border-l-4 border-blue-500 p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Total Pengguna</h3>
                    <span class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['total_users']) }}</span>
                </div>
                <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow border-l-4 border-green-500 p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Semua Karya</h3>
                    <span class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['total_novels']) }}</span>
                </div>
                <div class="bg-green-100 p-3 rounded-full text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow border-l-4 border-emerald-500 p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Telah Rilis</h3>
                    <span class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['total_published']) }}</span>
                </div>
                <div class="bg-emerald-100 p-3 rounded-full text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow border-l-4 border-purple-500 p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Interaksi Komentar</h3>
                    <span class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['total_comments']) }}</span>
                </div>
                <div class="bg-purple-100 p-3 rounded-full text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 mt-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">5 Pengguna Pendaftar Baru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mendaftar Pada</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($stats['recent_users'] as $u)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $u->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($u->role === 'admin')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Admin</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Reader</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
