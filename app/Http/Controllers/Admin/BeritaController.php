<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        return view('admin.beritas.index', [
            'beritas' => Berita::with('kategori')->latest('tanggal')->get()
        ]);
    }

    public function create()
    {
        return view('admin.beritas.form', [
            'berita'    => null,
            'kategoris' => Kategori::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'konten'      => 'required|string',
            'tanggal'     => 'required|date',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'gambar'      => 'nullable|image|max:5120',
        ]);

        $data = $request->only('judul', 'konten', 'tanggal', 'kategori_id');
        $data['slug']  = Str::slug($request->judul) . '-' . time();
        $data['aktif'] = $request->boolean('aktif', true);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('beritas', 'public');
        }

        Berita::create($data);
        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.beritas.form', [
            'berita'    => $berita,
            'kategoris' => Kategori::all()
        ]);
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'konten'      => 'required|string',
            'tanggal'     => 'required|date',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'gambar'      => 'nullable|image|max:5120',
        ]);

        $data = $request->only('judul', 'konten', 'tanggal', 'kategori_id');
        $data['aktif'] = $request->boolean('aktif');

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
            $data['gambar'] = $request->file('gambar')->store('beritas', 'public');
        }

        $berita->update($data);
        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
        $berita->delete();
        return back()->with('success', 'Berita berhasil dihapus.');
    }
}
