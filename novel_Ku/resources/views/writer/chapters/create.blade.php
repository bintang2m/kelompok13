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
                        <div class="w-2/4">
                            <label class="block text-gray-700 font-bold mb-2">Judul Bab</label>
                            <input type="text" name="title" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                        <div class="w-1/4">
                            <label class="block text-gray-700 font-bold mb-2">Status</label>
                            <select name="publish_status" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                <option value="published">Publis</option>
                                <option value="draft">Draft</option>
                            </select>
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