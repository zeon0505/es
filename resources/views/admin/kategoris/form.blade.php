@extends('layouts.admin')
@section('title', $kategori ? 'Edit Kategori' : 'Tambah Kategori')
@section('breadcrumb', 'Kategori Berita / ' . ($kategori ? 'Edit' : 'Tambah Baru'))

@section('content')
<div class="max-w-md">
  <form action="{{ $kategori ? route('admin.kategoris.update', $kategori) : route('admin.kategoris.store') }}"
        method="POST" class="space-y-5">
    @csrf
    @if($kategori) @method('PUT') @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Nama Kategori <span class="text-red-500">*</span></label>
        <input type="text" name="nama" value="{{ old('nama', $kategori?->nama) }}" required autofocus
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
          placeholder="Contoh: Kegiatan, Prestasi, Akademik">
        <p class="text-xs text-gray-400">Slug akan dibuat otomatis dari nama kategori.</p>
      </div>

      @if($kategori)
      <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
        <p class="text-xs text-gray-500">Slug saat ini: <code class="font-mono font-bold text-teal-700">{{ $kategori->slug }}</code></p>
      </div>
      @endif
    </div>

    <div class="flex gap-3">
      <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow transition-colors flex items-center gap-2">
        <i class="fas fa-save"></i> {{ $kategori ? 'Perbarui' : 'Simpan Kategori' }}
      </button>
      <a href="{{ route('admin.kategoris.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
        Batal
      </a>
    </div>
  </form>
</div>
@endsection
