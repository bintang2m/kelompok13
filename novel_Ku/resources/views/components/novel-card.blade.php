@props(['novel'])

<div class="group relative bg-gray-100 rounded-lg overflow-hidden flex flex-col hover:shadow-lg transition duration-200 border border-gray-200">
    <a href="{{ route('novels.show', $novel) }}" class="absolute inset-0 z-10"></a>
    <div class="aspect-[3/4] bg-gray-200 w-full overflow-hidden relative">
        @if($novel->cover)
            <img src="{{ Storage::url($novel->cover) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif

        <div class="absolute top-2 right-2 flex flex-col items-end gap-1">
            @if(isset($novel->chapters_count))
                <span class="bg-black/70 backdrop-blur text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                    {{ $novel->chapters_count }} Bab
                </span>
            @endif
        </div>
    </div>
    <div class="p-4 bg-white flex-1 flex flex-col justify-between relative z-10">
        <div>
            <h3 class="font-bold text-gray-900 line-clamp-1 mb-1 text-sm">{{ $novel->title }}</h3>
            <p class="text-[11px] text-gray-500 mb-2">Author: {{ $novel->author->name }}</p>
        </div>
        @php
            $avgRating = $novel->reviews()->avg('rating') ?? 0;
        @endphp
        <div class="flex justify-between items-center text-[10px] text-gray-400 font-semibold">
            <span class="text-yellow-500">⭐ {{ number_format($avgRating, 1) }}</span>
            <span>👀 {{ number_format($novel->views) }} Views</span>
        </div>
    </div>
</div>
