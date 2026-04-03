<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\Notification;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function index()
    {
        $pendingNovels = Novel::where('publish_status', 'pending')->with('author')->orderBy('created_at', 'desc')->get();
        $publishedNovels = Novel::where('publish_status', 'published')->with('author')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.novels.index', compact('pendingNovels', 'publishedNovels'));
    }
    
    public function update(Request $request, Novel $novel)
    {
        $action = $request->input('action');
        
        if ($action === 'approve') {
            $novel->update(['publish_status' => 'published']);
            
            Notification::create([
                'user_id' => $novel->user_id,
                'title' => 'Novel Diterima!',
                'message' => 'Selamat, karya Anda yang berjudul "' . $novel->title . '" telah lolos moderasi Admin dan resmi didistribusikan di beranda utamal.',
                'is_read' => false,
            ]);
            
            return back()->with('success', 'Novel disetujui untuk rilis publik!');
        }
        
        if ($action === 'reject') {
            $novel->update(['publish_status' => 'draft']);
            
            Notification::create([
                'user_id' => $novel->user_id,
                'title' => 'Publikasi Ditolak',
                'message' => 'Maaf, pengajuan rilis novel "' . $novel->title . '" ditolak oleh Admin. Status karya telah dikembalikan ke mode Draft pribadi Anda.',
                'is_read' => false,
            ]);
            
            return back()->with('error', 'Novel ditolak dan dikembalikan sebagai Draft untuk diperbaiki.');
        }

        return back();
    }
    
    public function destroy(Novel $novel)
    {
        $novel->delete();
        return back()->with('success', 'Novel bimbingan tersebut berhasil dilenyapkan dari database.');
    }
}
