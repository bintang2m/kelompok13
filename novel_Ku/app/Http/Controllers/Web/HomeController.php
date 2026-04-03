<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $publishedChapterCount = ['chapters' => function($query) {
            $query->where('publish_status', 'published');
        }];

        $featuredNovels = Novel::where('publish_status', 'published')
            ->with(['author'])
            ->withCount($publishedChapterCount)
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();
            
        $popularNovels = Novel::where('publish_status', 'published')
            ->with(['author'])
            ->withCount($publishedChapterCount)
            ->orderBy('views', 'desc')
            ->take(7)
            ->get();

        $latestNovels = Novel::where('publish_status', 'published')
            ->with(['author'])
            ->withCount($publishedChapterCount)
            ->orderBy('created_at', 'desc')
            ->take(7)
            ->get();

        $allNovels = Novel::where('publish_status', 'published')
            ->with(['author'])
            ->withCount($publishedChapterCount)
            ->orderBy('title', 'asc')
            ->paginate(12);

        $banners = \App\Models\Banner::orderBy('order', 'asc')->get();

        return view('home', compact('featuredNovels', 'popularNovels', 'latestNovels', 'allNovels', 'banners'));
    }
}
