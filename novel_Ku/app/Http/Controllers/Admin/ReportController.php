<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'novel'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.reports.index', compact('reports'));
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return back()->with('success', 'Laporan telah dihapus dari antrean.');
    }
}
