<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        return view('admin.slides.index', ['slides' => Slide::orderBy('urutan')->get()]);
    }

    public function create()
    {
        return view('admin.slides.form', ['slide' => null]);
    }

    public function store(Request $request)
    {
        $request->validate(['gambar' => 'required|image|max:5120', 'judul' => 'nullable|string|max:255']);

        $path = $request->file('gambar')->store('slides', 'public');
        Slide::create(['judul' => $request->judul, 'gambar' => $path, 'urutan' => $request->urutan ?? 0, 'aktif' => $request->boolean('aktif', true)]);

        return redirect()->route('admin.slides.index')->with('success', 'Slide berhasil ditambahkan.');
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.form', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $request->validate(['gambar' => 'nullable|image|max:5120', 'judul' => 'nullable|string|max:255']);

        $data = ['judul' => $request->judul, 'urutan' => $request->urutan ?? $slide->urutan, 'aktif' => $request->boolean('aktif')];

        if ($request->hasFile('gambar')) {
            if ($slide->gambar) Storage::disk('public')->delete($slide->gambar);
            $data['gambar'] = $request->file('gambar')->store('slides', 'public');
        }

        $slide->update($data);
        return redirect()->route('admin.slides.index')->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(Slide $slide)
    {
        if ($slide->gambar) Storage::disk('public')->delete($slide->gambar);
        $slide->delete();
        return back()->with('success', 'Slide berhasil dihapus.');
    }
}
