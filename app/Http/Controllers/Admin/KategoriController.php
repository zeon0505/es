<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        return view('admin.kategoris.index', ['kategoris' => Kategori::withCount('beritas')->get()]);
    }

    public function create()
    {
        return view('admin.kategoris.form', ['kategori' => null]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255|unique:kategoris,nama']);
        Kategori::create(['nama' => $request->nama, 'slug' => Str::slug($request->nama)]);
        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategoris.form', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate(['nama' => 'required|string|max:255|unique:kategoris,nama,' . $kategori->id]);
        $kategori->update(['nama' => $request->nama, 'slug' => Str::slug($request->nama)]);
        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
