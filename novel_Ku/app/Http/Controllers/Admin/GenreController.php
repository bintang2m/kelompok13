<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('novels')->orderBy('name', 'asc')->paginate(15);
        return view('admin.genres.index', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:genres,name',
        ]);
        
        Genre::create(['name' => $request->name]);
        return back()->with('success', 'Kategori Genre baru berhasil ditambahkan!');
    }
    
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:genres,name,'.$genre->id,
        ]);
        
        $genre->update(['name' => $request->name]);
        return back()->with('success', 'Nama kategori genre berhasil diperbarui!');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return back()->with('success', 'Genre berhasil dihapus dari daftar master.');
    }
}
