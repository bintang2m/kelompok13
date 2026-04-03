<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    public function index(Novel $novel)
    {
        if ($novel->user_id !== Auth::id()) abort(403);
        $chapters = $novel->chapters()->orderBy('chapter_number', 'asc')->paginate(20);
        return view('writer.chapters.index', compact('novel', 'chapters'));
    }

    public function create(Novel $novel)
    {
        if ($novel->user_id !== Auth::id()) abort(403);
        $nextNumber = $novel->chapters()->max('chapter_number') + 1;
        return view('writer.chapters.create', compact('novel', 'nextNumber'));
    }

    public function store(Request $request, Novel $novel)
    {
        if ($novel->user_id !== Auth::id()) abort(403);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_number' => 'required|integer|min:1',
            'publish_status' => 'required|in:published,draft',
        ]);

        $novel->chapters()->create([
            'title' => $request->title,
            'content' => $request->content,
            'chapter_number' => $request->chapter_number,
            'views' => 0,
            'publish_status' => $request->publish_status,
        ]);

        return redirect()->route('writer.novels.chapters.index', $novel)->with('success', 'Bab berhasil ditambahkan!');
    }

    // Public: Read chapter
    public function show(Novel $novel, Chapter $chapter)
    {
        if ($chapter->publish_status === 'draft' && Auth::id() !== $novel->user_id) abort(404);

        $chapter->increment('views');
        
        if (Auth::check()) {
            \App\Models\ReadingHistory::updateOrCreate(
                ['user_id' => Auth::id(), 'novel_id' => $novel->id],
                ['chapter_id' => $chapter->id, 'last_read_at' => now()]
            );
        }
        
        // Cuma ambil next/prev dari bab yg published
        $prevChapter = Chapter::where('novel_id', $novel->id)->where('publish_status', 'published')->where('chapter_number', '<', $chapter->chapter_number)->orderBy('chapter_number', 'desc')->first();
        $nextChapter = Chapter::where('novel_id', $novel->id)->where('publish_status', 'published')->where('chapter_number', '>', $chapter->chapter_number)->orderBy('chapter_number', 'asc')->first();

        return view('chapters.show', compact('novel', 'chapter', 'prevChapter', 'nextChapter'));
    }

    public function edit(Novel $novel, Chapter $chapter)
    {
        if ($novel->user_id !== Auth::id()) abort(403);
        return view('writer.chapters.edit', compact('novel', 'chapter'));
    }

    public function update(Request $request, Novel $novel, Chapter $chapter)
    {
        if ($novel->user_id !== Auth::id()) abort(403);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_number' => 'required|integer|min:1',
            'publish_status' => 'required|in:published,draft',
        ]);

        $chapter->update([
            'title' => $request->title,
            'content' => $request->content,
            'chapter_number' => $request->chapter_number,
            'publish_status' => $request->publish_status,
        ]);

        return redirect()->route('writer.novels.chapters.index', $novel)->with('success', 'Bab berhasil diperbarui!');
    }

    public function destroy(Novel $novel, Chapter $chapter)
    {
        if ($novel->user_id !== Auth::id()) abort(403);
        $chapter->delete();
        return redirect()->route('writer.novels.chapters.index', $novel)->with('success', 'Chapter berhasil dihapus!');
    }
}
