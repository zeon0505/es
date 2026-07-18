<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index()
    {
        return view('admin.dosens.index', ['dosens' => Dosen::orderBy('urutan')->get()]);
    }

    public function create()
    {
        return view('admin.dosens.form', ['dosen' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'foto'    => 'nullable|image|max:3072',
            'program_studi' => 'nullable|string|max:255',
            'jabatan_akademik' => 'nullable|string|max:255',
            'status_pegawai' => 'nullable|string|max:255',
            'nidn' => 'nullable|string|max:255|unique:dosens,nidn',
            'nuptk' => 'nullable|string|max:255|unique:dosens,nuptk',
            'google_scholar_link' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255|unique:dosens,email',
            'pendidikan_terakhir' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'nama', 'jabatan', 'urutan', 'program_studi', 'jabatan_akademik',
            'status_pegawai', 'nidn', 'nuptk', 'google_scholar_link', 'email', 'pendidikan_terakhir'
        ]);
        $data['aktif'] = $request->boolean('aktif', true);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('dosens', 'public');
        } elseif ($request->filled('foto_url')) {
            $data['foto'] = $request->foto_url;
        }

        Dosen::create($data);
        return redirect()->route('admin.dosens.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen)
    {
        return view('admin.dosens.form', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'foto'    => 'nullable|image|max:3072',
            'program_studi' => 'nullable|string|max:255',
            'jabatan_akademik' => 'nullable|string|max:255',
            'status_pegawai' => 'nullable|string|max:255',
            'nidn' => 'nullable|string|max:255|unique:dosens,nidn,' . $dosen->id,
            'nuptk' => 'nullable|string|max:255|unique:dosens,nuptk,' . $dosen->id,
            'google_scholar_link' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255|unique:dosens,email,' . $dosen->id,
            'pendidikan_terakhir' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'nama', 'jabatan', 'urutan', 'program_studi', 'jabatan_akademik',
            'status_pegawai', 'nidn', 'nuptk', 'google_scholar_link', 'email', 'pendidikan_terakhir'
        ]);
        $data['aktif'] = $request->boolean('aktif');

        if ($request->hasFile('foto')) {
            if ($dosen->foto && !str_starts_with($dosen->foto, 'http')) {
                Storage::disk('public')->delete($dosen->foto);
            }
            $data['foto'] = $request->file('foto')->store('dosens', 'public');
        } elseif ($request->filled('foto_url')) {
            $data['foto'] = $request->foto_url;
        }

        $dosen->update($data);
        return redirect()->route('admin.dosens.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        if ($dosen->foto && !str_starts_with($dosen->foto, 'http')) {
            Storage::disk('public')->delete($dosen->foto);
        }
        $dosen->delete();
        return back()->with('success', 'Dosen berhasil dihapus.');
    }
}