<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Novel;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Novel $novel)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'chapter_id' => 'nullable|exists:chapters,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = $novel->comments()->create([
            'user_id' => Auth::id(),
            'chapter_id' => $request->chapter_id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        if ($request->parent_id) {
            $parentComment = Comment::find($request->parent_id);
            if ($parentComment && $parentComment->user_id !== Auth::id()) {
                Notification::create([
                    'user_id' => $parentComment->user_id,
                    'title' => 'Balasan Baru',
                    'message' => Auth::user()->name . ' membalas komentar Anda di novel ' . $novel->title,
                    'is_read' => false,
                ]);
            }
        } else if ($novel->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $novel->user_id,
                'title' => 'Komentar Baru',
                'message' => Auth::user()->name . ' mengomentari novel ' . $novel->title,
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
