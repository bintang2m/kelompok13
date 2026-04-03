<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Novel;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_novels' => Novel::count(),
            'total_published' => Novel::where('publish_status', 'published')->count(),
            'total_comments' => Comment::count(),
            'recent_users' => User::orderBy('created_at', 'desc')->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
