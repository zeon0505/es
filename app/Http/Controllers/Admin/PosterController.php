<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosterController extends Controller
{
    public function index()
    {
        return view('admin.posters.index', ['posters' => Poster::latest()->get()]);
    }

    public function create()
    {
        return view('admin.posters.form', ['poster' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'kategori'  => 'nullable|string|max:100',
            'gambar'    => 'nullable|image|max:5120',
        ]);

        $data = $request->only('judul', 'deskripsi', 'kategori');
        $data['aktif'] = $request->boolean('aktif', true);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('posters', 'public');
        }

        Poster::create($data);
        return redirect()->route('admin.posters.index')->with('success', 'Poster berhasil ditambahkan.');
    }

    public function edit(Poster $poster)
    {
        return view('admin.posters.form', compact('poster'));
    }

    public function update(Request $request, Poster $poster)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'kategori'  => 'nullable|string|max:100',
            'gambar'    => 'nullable|image|max:5120',
        ]);

        $data = $request->only('judul', 'deskripsi', 'kategori');
        $data['aktif'] = $request->boolean('aktif');

        if ($request->hasFile('gambar')) {
            if ($poster->gambar) Storage::disk('public')->delete($poster->gambar);
            $data['gambar'] = $request->file('gambar')->store('posters', 'public');
        }

        $poster->update($data);
        return redirect()->route('admin.posters.index')->with('success', 'Poster berhasil diperbarui.');
    }

    public function destroy(Poster $poster)
    {
        if ($poster->gambar) Storage::disk('public')->delete($poster->gambar);
        $poster->delete();
        return back()->with('success', 'Poster berhasil dihapus.');
    }
}
