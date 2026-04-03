<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Novel;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'novel_id' => 'required|exists:novels,id',
            'reason' => 'required|string|max:1000',
        ]);

        $novel = Novel::findOrFail($request->novel_id);

        Report::create([
            'user_id' => auth()->id(),
            'novel_id' => $novel->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Notify Novel Creator
        if ($novel->user_id !== auth()->id()) {
            Notification::create([
                'user_id' => $novel->user_id,
                'title' => '⚠️ Peringatan Laporan Karya',
                'message' => 'Seorang pengguna melaporkan karya Anda yang berjudul "' . $novel->title . '". Alasan: ' . $request->reason . '. Mohon segera tinjau kembali konten tersebut agar tidak berpotensi di-Takedown Admin.',
                'is_read' => false,
            ]);
        }

        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => '🚨 Laporan Novel Baru (Review Required)',
                'message' => 'Ada Laporan untuk novel "' . $novel->title . '" | Keluhan: ' . $request->reason,
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Keluhan berhasil terkirim. Penulis & Admin terkait telah dikabari melalui Notifikasi!');
    }
}
