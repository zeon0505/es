@extends('layouts.admin')
@section('title', $berita ? 'Edit Berita' : 'Tulis Berita')
@section('breadcrumb', 'Berita Ekonomi Syariah / ' . ($berita ? 'Edit' : 'Tulis Baru'))

@section('content')

{{-- ═══ IMPORT DARI URL (hanya saat create) ═══ --}}
@if(!$berita)
<div id="import-card" class="bg-gradient-to-r from-teal-50 to-emerald-50 border border-teal-200 rounded-2xl p-5 mb-6 shadow-sm">
  <div class="flex items-center gap-2 mb-3">
    <span class="text-lg">🔗</span>
    <h3 class="font-bold text-teal-800 text-sm">Import Otomatis dari URL STAIMAS</h3>
    <span class="text-xs text-teal-600 bg-teal-100 px-2 py-0.5 rounded-full">Opsional</span>
  </div>
  <p class="text-xs text-teal-700 mb-3">Tempel link berita dari website STAIMAS — judul, isi, gambar, dan tanggal akan terisi otomatis.</p>

  <div class="flex gap-2">
    <input type="url" id="import-url"
      class="flex-1 px-4 py-2.5 rounded-xl border border-teal-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 placeholder-gray-400"
      placeholder="https://www.staimaswonogiri.ac.id/...">
    <button type="button" id="import-btn"
      class="flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white font-semibold px-5 py-2.5 rounded-xl text-sm shadow transition-colors whitespace-nowrap">
      <span id="import-icon">⚡</span>
      <span id="import-text">Ambil Konten</span>
    </button>
  </div>

  {{-- Status --}}
  <div id="import-status" class="hidden mt-3 text-sm px-4 py-2.5 rounded-xl"></div>
</div>
@endif

<form action="{{ $berita ? route('admin.beritas.update', $berita) : route('admin.beritas.store') }}"
      method="POST" enctype="multipart/form-data" id="berita-form">
  @csrf
  @if($berita) @method('PUT') @endif

  {{-- Hidden field untuk gambar hasil scrape --}}
  <input type="hidden" name="gambar_scraped" id="gambar-scraped-path">

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom Kiri: Konten --}}
    <div class="lg:col-span-2 space-y-5">
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Judul Berita <span class="text-red-500">*</span></label>
          <input type="text" name="judul" id="field-judul" value="{{ old('judul', $berita?->judul) }}" required autofocus
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all"
            placeholder="Tulis judul berita yang menarik...">
        </div>

        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Isi Berita <span class="text-red-500">*</span></label>
          <textarea name="konten" id="field-konten" rows="14" required
            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 leading-relaxed resize-y transition-all"
            placeholder="Tulis isi berita lengkap di sini...">{{ old('konten', $berita?->konten) }}</textarea>
        </div>
      </div>

      {{-- Gambar --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
        <h3 class="font-bold text-gray-800 text-sm">Gambar Berita</h3>

        {{-- Preview gambar dari scrape --}}
        <div id="scraped-preview-container" class="hidden space-y-2">
          <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-full">✅ Gambar dari URL</span>
            <button type="button" id="remove-scraped-img" class="text-xs text-red-500 hover:text-red-700">Hapus</button>
          </div>
          <img id="scraped-preview-img" src="" alt="Preview" class="aspect-video w-full max-w-md object-cover rounded-xl border border-gray-200">
        </div>

        @if($berita && $berita->gambar)
        <div class="space-y-1.5">
          <p class="text-xs text-gray-500 font-semibold">Gambar Saat Ini</p>
          <div class="aspect-video w-full max-w-md rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Preview" class="w-full h-full object-cover">
          </div>
        </div>
        @endif

        <div class="space-y-1.5" id="upload-section">
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
          <select name="kategori_id" id="field-kategori" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
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
          <input type="date" name="tanggal" id="field-tanggal" value="{{ old('tanggal', $berita?->tanggal?->format('Y-m-d') ?? date('Y-m-d')) }}" required
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
// ── Preview gambar upload manual ──
document.getElementById('gambar-input').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = evt => {
    document.getElementById('preview-img').src = evt.target.result;
    document.getElementById('preview-container').classList.remove('hidden');
    clearScrapedImage();
  };
  reader.readAsDataURL(file);
});

function clearScrapedImage() {
  const path = document.getElementById('gambar-scraped-path');
  const img  = document.getElementById('scraped-preview-img');
  const wrap = document.getElementById('scraped-preview-container');
  if (path) path.value = '';
  if (img)  img.src   = '';
  if (wrap) wrap.classList.add('hidden');
}

// ── Import dari URL (hanya aktif di mode create) ──
const importBtn  = document.getElementById('import-btn');
const importUrl  = document.getElementById('import-url');
const importStat = document.getElementById('import-status');

if (importBtn) {
  importBtn.addEventListener('click', async function() {
    const url = importUrl.value.trim();
    if (!url) { showStatus('error', 'Masukkan URL terlebih dahulu.'); return; }

    setLoading(true);
    showStatus('info', '⏳ Mengambil konten dari URL...');

    try {
      const res = await fetch('{{ route("admin.beritas.scrape-url") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ url })
      });

      const data = await res.json();

      if (!res.ok) {
        showStatus('error', '❌ ' + (data.error ?? 'Gagal mengambil konten.'));
        return;
      }

      if (data.judul)   document.getElementById('field-judul').value   = data.judul;
      if (data.konten)  document.getElementById('field-konten').value  = data.konten;
      if (data.tanggal) document.getElementById('field-tanggal').value = data.tanggal;

      if (data.gambar && data.gambar_preview) {
        document.getElementById('gambar-scraped-path').value = data.gambar;
        document.getElementById('scraped-preview-img').src   = data.gambar_preview;
        document.getElementById('scraped-preview-container').classList.remove('hidden');
      }

      showStatus('success', '✅ Konten berhasil diimpor! Periksa dan sesuaikan sebelum menerbitkan.');

    } catch (err) {
      showStatus('error', '❌ Gagal terhubung ke server. Coba lagi.');
    } finally {
      setLoading(false);
    }
  });

  document.getElementById('remove-scraped-img').addEventListener('click', clearScrapedImage);
}

function setLoading(on) {
  if (!importBtn) return;
  importBtn.disabled = on;
  document.getElementById('import-icon').textContent = on ? '⏳' : '⚡';
  document.getElementById('import-text').textContent = on ? 'Mengambil...' : 'Ambil Konten';
}

function showStatus(type, msg) {
  if (!importStat) return;
  importStat.classList.remove('hidden',
    'bg-green-50', 'text-green-700', 'border-green-200',
    'bg-red-50',   'text-red-700',   'border-red-200',
    'bg-blue-50',  'text-blue-700',  'border-blue-200');
  importStat.classList.add('border');
  const map = {
    success: ['bg-green-50','text-green-700','border-green-200'],
    error:   ['bg-red-50',  'text-red-700',  'border-red-200'],
    info:    ['bg-blue-50', 'text-blue-700', 'border-blue-200'],
  };
  importStat.classList.add(...(map[type] ?? map.info));
  importStat.textContent = msg;
}
</script>
@endsection
