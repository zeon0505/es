@extends('layouts.admin')
@section('title', $poster ? 'Edit Poster' : 'Tambah Poster')
@section('breadcrumb', 'Poster & Pengumuman / ' . ($poster ? 'Edit' : 'Tambah Baru'))

@section('content')
<div class="max-w-2xl">
  <form action="{{ $poster ? route('admin.posters.update', $poster) : route('admin.posters.store') }}"
        method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($poster) @method('PUT') @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">

      {{-- Preview poster saat ini --}}
      @if($poster && $poster->gambar)
      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Poster Saat Ini</label>
        <div class="w-40 aspect-[3/4] rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
          <img src="{{ asset('storage/' . $poster->gambar) }}" alt="{{ $poster->judul }}" class="w-full h-full object-cover">
        </div>
      </div>
      @endif

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Judul Poster <span class="text-red-500">*</span></label>
        <input type="text" name="judul" value="{{ old('judul', $poster?->judul) }}" required autofocus
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
          placeholder="Contoh: PMB Ekonomi Syariah 2025">
      </div>

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Deskripsi Singkat</label>
        <input type="text" name="deskripsi" value="{{ old('deskripsi', $poster?->deskripsi) }}"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
          placeholder="Contoh: Info kegiatan Program Studi Ekonomi Syariah">
      </div>

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Penjelasan / Isi Lengkap Poster <span class="text-gray-400">(Tampil saat poster diklik)</span></label>
        <textarea name="konten" rows="8"
          class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 leading-relaxed resize-y"
          placeholder="Tuliskan keterangan lengkap, pengumuman detail, syarat & ketentuan, jadwal, atau informasi seputar poster ini...">{{ old('konten', $poster?->konten) }}</textarea>
      </div>

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori', $poster?->kategori ?? 'Umum') }}" list="kategori-list"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
          placeholder="Contoh: PMB, Beasiswa, Kegiatan, Akademik">
        <datalist id="kategori-list">
          <option value="PMB">
          <option value="Beasiswa">
          <option value="Kegiatan">
          <option value="Akademik">
          <option value="Umum">
        </datalist>
      </div>

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Upload Gambar Poster <span class="text-gray-400">(opsional, maks 5MB)</span></label>
        <input type="file" name="gambar" accept="image/*" id="gambar-input"
          class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold hover:file:bg-teal-100">
        <p class="text-xs text-gray-400">Format: JPG, PNG, WEBP. Rasio potret (3:4) direkomendasikan untuk poster.</p>
        <div id="preview-container" class="hidden mt-2">
          <img id="preview-img" src="" alt="Preview" class="w-40 aspect-[3/4] object-cover rounded-xl border border-gray-200">
        </div>
      </div>

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Status</label>
        <select name="aktif" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
          <option value="1" {{ old('aktif', $poster?->aktif ?? 1) == 1 ? 'selected' : '' }}>Aktif (tampil di website)</option>
          <option value="0" {{ old('aktif', $poster?->aktif) == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>
    </div>

    <div class="flex gap-3">
      <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow transition-colors flex items-center gap-2">
        <i class="fas fa-save"></i> {{ $poster ? 'Perbarui Poster' : 'Simpan Poster' }}
      </button>
      <a href="{{ route('admin.posters.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
        Batal
      </a>
    </div>
  </form>
</div>

<script>
document.getElementById('gambar-input').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = evt => {
    document.getElementById('preview-img').src = evt.target.result;
    document.getElementById('preview-container').classList.remove('hidden');
  };
  reader.readAsDataURL(file);
});
</script>
@endsection
