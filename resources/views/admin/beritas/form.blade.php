@extends('layouts.admin')
@section('title', $berita ? 'Edit Berita' : 'Tulis Berita')
@section('breadcrumb', 'Berita Ekonomi Syariah / ' . ($berita ? 'Edit' : 'Tulis Baru'))

@section('content')
<form action="{{ $berita ? route('admin.beritas.update', $berita) : route('admin.beritas.store') }}"
      method="POST" enctype="multipart/form-data">
  @csrf
  @if($berita) @method('PUT') @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom Kiri: Konten --}}
    <div class="lg:col-span-2 space-y-5">
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Judul Berita <span class="text-red-500">*</span></label>
          <input type="text" name="judul" value="{{ old('judul', $berita?->judul) }}" required autofocus
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Tulis judul berita yang menarik...">
        </div>

        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Isi Berita <span class="text-red-500">*</span></label>
          <textarea name="konten" rows="14" required
            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 leading-relaxed resize-y"
            placeholder="Tulis isi berita lengkap di sini...">{{ old('konten', $berita?->konten) }}</textarea>
        </div>
      </div>

      {{-- Gambar --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
        <h3 class="font-bold text-gray-800 text-sm">Gambar Berita</h3>

        @if($berita && $berita->gambar)
        <div class="space-y-1.5">
          <p class="text-xs text-gray-500 font-semibold">Gambar Saat Ini</p>
          <div class="aspect-video w-full max-w-md rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Preview" class="w-full h-full object-cover">
          </div>
        </div>
        @endif

        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">{{ $berita ? 'Ganti Gambar' : 'Upload Gambar' }} <span class="text-gray-400">(opsional, maks 5MB)</span></label>
          <input type="file" name="gambar" accept="image/*" id="gambar-input"
            class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold hover:file:bg-teal-100">
          <div id="preview-container" class="hidden mt-2">
            <img id="preview-img" src="" alt="Preview" class="aspect-video w-full max-w-md object-cover rounded-xl border border-gray-200">
          </div>
        </div>
      </div>
    </div>

    {{-- Kolom Kanan: Meta --}}
    <div class="space-y-5">
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        <h3 class="font-bold text-gray-800 text-sm">Pengaturan Berita</h3>

        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Kategori</label>
          <select name="kategori_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="">— Tanpa Kategori —</option>
            @foreach($kategoris as $kat)
            <option value="{{ $kat->id }}" {{ old('kategori_id', $berita?->kategori_id) == $kat->id ? 'selected' : '' }}>
              {{ $kat->nama }}
            </option>
            @endforeach
          </select>
        </div>

        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Tanggal Terbit <span class="text-red-500">*</span></label>
          <input type="date" name="tanggal" value="{{ old('tanggal', $berita?->tanggal?->format('Y-m-d') ?? date('Y-m-d')) }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>

        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Status Publikasi</label>
          <select name="aktif" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="1" {{ old('aktif', $berita?->aktif ?? 1) == 1 ? 'selected' : '' }}>✅ Aktif (Tampil di publik)</option>
            <option value="0" {{ old('aktif', $berita?->aktif) == 0 ? 'selected' : '' }}>📝 Draft (Tidak tampil)</option>
          </select>
        </div>
      </div>

      <div class="flex flex-col gap-3">
        <button type="submit" class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold px-6 py-3 rounded-xl text-sm shadow transition-colors flex items-center justify-center gap-2">
          <i class="fas fa-save"></i> {{ $berita ? 'Perbarui Berita' : 'Terbitkan Berita' }}
        </button>
        <a href="{{ route('admin.beritas.index') }}" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
          Batal
        </a>
      </div>
    </div>
  </div>
</form>

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
