<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Novel;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Novel $novel)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $novel->reviews()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['rating' => $request->rating, 'comment' => '']
        );
        
        if ($novel->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $novel->user_id,
                'title' => 'Rating Baru',
                'message' => Auth::user()->name . ' memberi rating ' . $request->rating . ' bintang pada novel ' . $novel->title,
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Rating berhasil disimpan!');
    }
}
