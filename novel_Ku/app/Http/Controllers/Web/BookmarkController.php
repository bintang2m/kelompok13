<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Auth::user()->bookmarks()->with('novel.author')->paginate(12);
        return view('user.bookmarks', compact('bookmarks'));
    }

    public function toggle(Novel $novel)
    {
        $bookmark = Auth::user()->bookmarks()->where('novel_id', $novel->id)->first();
        
        if ($bookmark) {
            $bookmark->delete();
            return back()->with('success', 'Novel dihapus dari daftar simpanan.');
        }

        Auth::user()->bookmarks()->create(['novel_id' => $novel->id]);
        return back()->with('success', 'Novel berhasil disimpan!');
    }
}
