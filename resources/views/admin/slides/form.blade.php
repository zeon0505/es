@extends('layouts.admin')
@section('title', $slide ? 'Edit Slide' : 'Tambah Slide')
@section('breadcrumb', 'Hero Slider / ' . ($slide ? 'Edit' : 'Tambah Baru'))

@section('content')
<div class="max-w-2xl">
  <form action="{{ $slide ? route('admin.slides.update', $slide) : route('admin.slides.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($slide) @method('PUT') @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
      {{-- Preview gambar saat ini --}}
      @if($slide && $slide->gambar)
      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Gambar Saat Ini</label>
        <div class="w-full aspect-video rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
          <img src="{{ str_starts_with($slide->gambar, 'http') ? $slide->gambar : asset('storage/' . $slide->gambar) }}"
               alt="Preview" class="w-full h-full object-cover">
        </div>
      </div>
      @endif

      {{-- Upload gambar baru --}}
      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">{{ $slide ? 'Ganti Gambar' : 'Upload Gambar' }} <span class="{{ $slide ? 'text-gray-400' : 'text-red-500' }}">({{ $slide ? 'opsional' : 'wajib' }})</span></label>
        <input type="file" name="gambar" accept="image/*" id="gambar-input"
          class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold hover:file:bg-teal-100 transition-all">
        <p class="text-xs text-gray-400">Format: JPG, PNG, WEBP. Maks 5MB. Rasio 16:9 direkomendasikan.</p>
        <div id="preview-container" class="hidden mt-2">
          <img id="preview-img" src="" alt="Preview" class="w-full aspect-video object-cover rounded-xl border border-gray-200">
        </div>
      </div>

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Judul Slide <span class="text-gray-400">(opsional)</span></label>
        <input type="text" name="judul" value="{{ old('judul', $slide?->judul) }}"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
          placeholder="Contoh: Mahasiswa Ekonomi Syariah Angkatan 2025">
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Urutan</label>
          <input type="number" name="urutan" value="{{ old('urutan', $slide?->urutan ?? 0) }}" min="0"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Status</label>
          <select name="aktif" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="1" {{ old('aktif', $slide?->aktif ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('aktif', $slide?->aktif) == 0 ? 'selected' : '' }}>Nonaktif</option>
          </select>
        </div>
      </div>
    </div>

    <div class="flex gap-3">
      <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow transition-colors flex items-center gap-2">
        <i class="fas fa-save"></i> {{ $slide ? 'Perbarui Slide' : 'Simpan Slide' }}
      </button>
      <a href="{{ route('admin.slides.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
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
  reader.onload = function(evt) {
    document.getElementById('preview-img').src = evt.target.result;
    document.getElementById('preview-container').classList.remove('hidden');
  };
  reader.readAsDataURL(file);
});
</script>
@endsection
