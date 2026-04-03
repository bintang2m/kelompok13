<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Novel;
use App\Models\Chapter;
use App\Models\Review;

class StatisticController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Statistik Sebagai Pembaca (Reader)
        $readerStats = [
            'total_comments' => $user->comments()->count(),
            'total_bookmarks' => $user->bookmarks()->count(),
            'total_reviews' => $user->reviews()->count(),
        ];

        // 2. Statistik Sebagai Penulis (Writer)
        $novelIds = $user->novels()->pluck('id');
        
        $writerStats = [
            'total_novels' => $novelIds->count(),
            'total_chapters' => Chapter::whereIn('novel_id', $novelIds)->count(),
            'total_novel_views' => $user->novels()->sum('views'),
            'total_chapter_views' => Chapter::whereIn('novel_id', $novelIds)->sum('views'),
            'average_rating' => Review::whereIn('novel_id', $novelIds)->avg('rating') ?? 0,
            'published_novels' => $user->novels()->where('publish_status', 'published')->count(),
        ];

        return view('user.statistics', compact('readerStats', 'writerStats'));
    }
}
