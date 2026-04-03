<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NovelController extends Controller
{
    // Writer: List their novels
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'published');
        $query = Auth::user()->novels()->withCount('chapters')->orderBy('created_at', 'desc');
        
        if ($tab === 'draft') {
            $query->where('publish_status', 'draft');
        } elseif ($tab === 'pending') {
            $query->where('publish_status', 'pending');
        } else {
            $query->where('publish_status', 'published');
        }

        $novels = $query->paginate(10)->appends($request->query());
        
        $countPublished = Auth::user()->novels()->where('publish_status', 'published')->count();
        $countDraft = Auth::user()->novels()->where('publish_status', 'draft')->count();
        $countPending = Auth::user()->novels()->where('publish_status', 'pending')->count();

        return view('writer.novels.index', compact('novels', 'tab', 'countPublished', 'countDraft', 'countPending'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('writer.novels.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genres' => 'nullable|array',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|string',
            'publish_status' => 'required|string',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $finalPublishStatus = $request->publish_status;
        if ($finalPublishStatus === 'published') {
            $finalPublishStatus = 'pending'; // Require admin approval
        }

        $novel = Auth::user()->novels()->create([
            'title' => $request->title,
            'description' => $request->description,
            'cover' => $coverPath,
            'status' => $request->status,
            'publish_status' => $finalPublishStatus,
            'views' => 0,
        ]);

        if ($request->has('genres')) {
            $novel->genres()->sync($request->genres);
        }

        return redirect()->route('writer.novels.index')->with('success', 'Novel berhasil dibuat!');
    }

    // Public: Show novel detail
    public function show(Novel $novel)
    {
        $novel->increment('views');
        $novel->load(['author', 'genres', 'chapters' => function ($query) use ($novel) {
            if (Auth::id() !== $novel->user_id) {
                $query->where('publish_status', 'published');
            }
            $query->orderBy('chapter_number', 'asc');
        }]);

        return view('novels.show', compact('novel'));
    }

    public function edit(Novel $novel)
    {
        if ($novel->user_id !== Auth::id()) abort(403);
        $genres = Genre::all();
        $novel->load('genres');
        return view('writer.novels.edit', compact('novel', 'genres'));
    }

    public function update(Request $request, Novel $novel)
    {
        if ($novel->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genres' => 'nullable|array',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|string',
            'publish_status' => 'required|string',
        ]);

        $coverPath = $novel->cover;
        if ($request->hasFile('cover')) {
            if ($coverPath) Storage::disk('public')->delete($coverPath);
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $finalPublishStatus = $request->publish_status;
        if ($finalPublishStatus === 'published' && $novel->publish_status !== 'published') {
            $finalPublishStatus = 'pending'; // Require admin approval if changing to published
        } else if ($finalPublishStatus === 'published' && $novel->publish_status === 'published') {
            // Jika sudah terpublish (di approve admin), biarkan tetap published
            $finalPublishStatus = 'published'; 
        }

        $novel->update([
            'title' => $request->title,
            'description' => $request->description,
            'cover' => $coverPath,
            'status' => $request->status,
            'publish_status' => $finalPublishStatus,
        ]);

        if ($request->has('genres')) {
            $novel->genres()->sync($request->genres);
        } else {
            $novel->genres()->sync([]);
        }

        return redirect()->route('writer.novels.index')->with('success', 'Novel berhasil diperbarui!');
    }

    public function destroy(Novel $novel)
    {
        if ($novel->user_id !== Auth::id()) abort(403);
        if ($novel->cover) Storage::disk('public')->delete($novel->cover);
        $novel->delete();
        return redirect()->route('writer.novels.index')->with('success', 'Novel berhasil dihapus!');
    }
}
