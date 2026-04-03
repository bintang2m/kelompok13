<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'title' => 'nullable|string|max:100',
            'subtitle' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'image' => $imagePath,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'link' => $request->link,
            'button_text' => $request->button_text ?? 'BACA SEKARANG',
            'order' => $request->order ?? 0,
        ]);

        return back()->with('success', 'Banner berhasil ditambahkan ke Slider!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return back()->with('success', 'Banner dihapus dari Slider.');
    }
}
