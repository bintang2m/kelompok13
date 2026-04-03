<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-2">Kotak Masuk (Notifikasi)</h2>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    @forelse($notifications as $notification)
                        <div class="p-6 border-b border-gray-100 flex items-start justify-between hover:bg-gray-50 transition {{ $notification->is_read ? 'opacity-70' : 'bg-blue-50/50' }}">
                            <div>
                                <h4 class="font-bold text-sm {{ $notification->is_read ? 'text-gray-700' : 'text-blue-900' }}">{{ $notification->title }}</h4>
                                <p class="text-gray-600 mt-1 text-sm">{{ $notification->message }}</p>
                                <span class="text-xs text-gray-400 mt-2 block font-medium">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            @if(!$notification->is_read)
                                <form action="{{ route('inbox.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs px-3 py-1.5 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-100 shadow-sm transition">Tandai Dibaca</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 border border-gray-200 px-2 py-1 rounded bg-gray-50">Selesai Dibaca</span>
                            @endif
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <p>Tidak ada pesan notifikasi baru di kotak masuk Anda.</p>
                        </div>
                    @endforelse
                </div>
                
                @if($notifications->hasPages())
                    <div class="p-4 border-t">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
