<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'all'); // latest, popular, all
        $search = $request->query('search', '');

        $query = Novel::where('publish_status', 'published')->with(['author']);

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $genreId = $request->query('genre');
        if ($genreId) {
            $query->whereHas('genres', function($q) use ($genreId) {
                $q->where('genres.id', $genreId);
            });
            $genreModel = \App\Models\Genre::find($genreId);
        }

        $title = "Koleksi Semua Novel";
        if ($sort === 'popular') {
            $query->orderBy('views', 'desc');
            $title = "Semua Novel Populer";
        } elseif ($sort === 'latest') {
            $query->orderBy('created_at', 'desc');
            $title = "Novel Terbaru";
        } else {
            $query->orderBy('title', 'asc');
        }

        if (isset($genreModel) && $genreModel) {
            $title = "Genre: " . $genreModel->name;
        }
        if ($search) {
            $title = "Pencarian: " . $search;
        }

        $novels = $query->paginate(24)->appends($request->query());

        return view('explore.index', compact('novels', 'title', 'sort', 'search'));
    }
}
