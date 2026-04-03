<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = \App\Models\ReadingHistory::where('user_id', auth()->id())
            ->with(['novel', 'chapter'])
            ->orderBy('last_read_at', 'desc')
            ->paginate(12);

        return view('history.index', compact('histories'));
    }
}
