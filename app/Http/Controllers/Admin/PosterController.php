<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    private function sanitizeUtf8(?string $text): ?string
    {
        if (empty($text)) return $text;
        return preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $text);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'konten'    => 'nullable|string',
            'kategori'  => 'nullable|string|max:100',
            'gambar'    => 'nullable|image|max:5120',
        ]);

        $data = $request->only('judul', 'deskripsi', 'konten', 'kategori');
        $data['slug']  = Str::slug($request->judul) . '-' . time();
        $data['aktif'] = $request->boolean('aktif', true);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('posters', 'public');
        }

        try {
            Poster::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            $data['judul']     = $this->sanitizeUtf8($data['judul']);
            $data['deskripsi'] = $this->sanitizeUtf8($data['deskripsi']);
            $data['konten']    = $this->sanitizeUtf8($data['konten']);
            Poster::create($data);
        }

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
            'deskripsi' => 'nullable|string',
            'konten'    => 'nullable|string',
            'kategori'  => 'nullable|string|max:100',
            'gambar'    => 'nullable|image|max:5120',
        ]);

        $data = $request->only('judul', 'deskripsi', 'konten', 'kategori');
        $data['aktif'] = $request->boolean('aktif');
        if (empty($poster->slug)) {
            $data['slug'] = Str::slug($request->judul) . '-' . time();
        }

        if ($request->hasFile('gambar')) {
            if ($poster->gambar) Storage::disk('public')->delete($poster->gambar);
            $data['gambar'] = $request->file('gambar')->store('posters', 'public');
        }

        try {
            $poster->update($data);
        } catch (\Illuminate\Database\QueryException $e) {
            $data['judul']     = $this->sanitizeUtf8($data['judul']);
            $data['deskripsi'] = $this->sanitizeUtf8($data['deskripsi']);
            $data['konten']    = $this->sanitizeUtf8($data['konten']);
            $poster->update($data);
        }

        return redirect()->route('admin.posters.index')->with('success', 'Poster berhasil diperbarui.');
    }

    public function destroy(Poster $poster)
    {
        if ($poster->gambar) Storage::disk('public')->delete($poster->gambar);
        $poster->delete();
        return back()->with('success', 'Poster berhasil dihapus.');
    }
}
