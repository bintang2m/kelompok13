<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        // Get user's published novels
        $novels = $user->novels()
            ->where('publish_status', 'published')
            ->withCount('chapters')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Calculate statistics
        $totalViews = $user->novels()->where('publish_status', 'published')->sum('views');
        $totalNovels = $novels->total();

        return view('profile.show', compact('user', 'novels', 'totalViews', 'totalNovels'));
    }
}
