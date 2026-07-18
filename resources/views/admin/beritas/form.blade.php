@extends('layouts.admin')
@section('title', $berita ? 'Edit Berita' : 'Tulis Berita')
@section('breadcrumb', 'Berita Ekonomi Syariah / ' . ($berita ? 'Edit' : 'Tulis Baru'))

@section('content')
@if(!$berita)
  {{-- Switcher Mode Single / Bulk --}}
  <div class="flex gap-2 bg-gray-100 p-1.5 rounded-2xl w-fit mb-6">
    <button type="button" id="tab-mode-single" onclick="switchMode('single')"
      class="mode-btn px-6 py-2 rounded-xl text-xs font-bold transition-all bg-white text-teal-700 shadow-sm">
      <i class="fas fa-file-alt mr-1.5"></i> Tulis Satu Berita
    </button>
    <button type="button" id="tab-mode-bulk" onclick="switchMode('bulk')"
      class="mode-btn px-6 py-2 rounded-xl text-xs font-bold transition-all text-gray-500 hover:text-gray-700">
      <i class="fas fa-copy mr-1.5"></i> Upload Massal (1-3 Link)
    </button>
  </div>
@endif

<div id="section-single-upload">
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
          <label class="text-sm font-semibold text-gray-700">Link Berita <span class="text-gray-400">(opsional, gambar akan otomatis diambil dari link)</span></label>
          <div class="flex gap-2">
            <input type="url" name="link" id="link-url-input" value="{{ old('link', $berita?->link) }}"
              class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
              placeholder="https://www.staimaswonogiri.ac.id/berita-...">
            <button type="button" id="btn-fetch-link" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors flex items-center gap-1.5 whitespace-nowrap">
              <i class="fas fa-sync-alt" id="fetch-spinner"></i> Ambil Data Link
            </button>
          </div>
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

        {{-- Tab Switcher --}}
        <div class="flex gap-1 bg-gray-100 p-1 rounded-xl w-fit">
          <button type="button" id="tab-upload" onclick="switchTab('upload')"
            class="tab-btn px-4 py-1.5 rounded-lg text-xs font-semibold transition-all bg-white text-teal-700 shadow-sm">
            <i class="fas fa-upload mr-1"></i> Upload File
          </button>
          <button type="button" id="tab-link" onclick="switchTab('link')"
            class="tab-btn px-4 py-1.5 rounded-lg text-xs font-semibold transition-all text-gray-500 hover:text-gray-700">
            <i class="fas fa-link mr-1"></i> Link URL
          </button>
        </div>

        {{-- Panel Upload File --}}
        <div id="panel-upload" class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">{{ $berita ? 'Ganti Gambar' : 'Upload Gambar' }} <span class="text-gray-400">(maks 5MB)</span></label>
          <input type="file" name="gambar" accept="image/*" id="gambar-input"
            class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold hover:file:bg-teal-100">
          <div id="preview-container" class="hidden mt-2">
            <img id="preview-img" src="" alt="Preview" class="aspect-video w-full max-w-md object-cover rounded-xl border border-gray-200">
          </div>
        </div>

        {{-- Panel Link URL --}}
        <div id="panel-link" class="hidden space-y-2">
          <label class="text-sm font-semibold text-gray-700">URL Gambar <span class="text-gray-400">(link langsung ke file gambar)</span></label>
          <div class="flex gap-2">
            <input type="url" id="gambar-url-input" name="gambar_url"
              class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
              placeholder="https://example.com/foto-berita.jpg">
            <button type="button" id="btn-preview-img-url"
              class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors whitespace-nowrap">
              <i class="fas fa-eye mr-1"></i> Preview
            </button>
          </div>
          <div id="preview-url-container" class="hidden mt-2">
            <img id="preview-url-img" src="" alt="Preview URL" class="aspect-video w-full max-w-md object-cover rounded-xl border border-gray-200">
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
</div>

@if(!$berita)
<div id="section-bulk-upload" class="hidden">
  <form action="{{ route('admin.beritas.store-bulk') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    {{-- Input URL Massal --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
      <h3 class="font-bold text-gray-800 text-sm">Upload Massal Berita (1-3 Link sekaligus)</h3>
      <p class="text-xs text-gray-500">Masukkan tautan (link) berita di bawah ini, lalu klik "Ambil Semua Data Link" untuk mengekstrak data secara otomatis.</p>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @for($i = 0; $i < 3; $i++)
        <div class="space-y-1.5">
          <label class="text-xs font-semibold text-gray-700">Link Berita {{ $i + 1 }}</label>
          <input type="url" id="bulk-url-input-{{ $i }}" placeholder="https://www.staimaswonogiri.ac.id/berita-{{ $i + 1 }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
        @endfor
      </div>

      <div class="flex justify-end pt-2">
        <button type="button" id="btn-fetch-bulk" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-colors flex items-center gap-1.5 shadow-sm">
          <i class="fas fa-sync-alt animate-none" id="fetch-spinner-bulk"></i> Ambil Semua Data Link
        </button>
      </div>
    </div>

    {{-- Detail Form Masing-masing Berita --}}
    <div class="space-y-6">
      @for($i = 0; $i < 3; $i++)
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-50 pb-3">
          <h4 class="font-bold text-teal-800 text-sm">Berita Slot {{ $i + 1 }}</h4>
          <span id="bulk-status-badge-{{ $i }}" class="text-[10px] bg-gray-100 text-gray-500 font-bold px-2.5 py-1 rounded-full">Kosong / Menunggu Link</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {{-- Konten --}}
          <div class="lg:col-span-2 space-y-4">
            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-gray-700">Judul Berita <span class="text-red-500">*</span></label>
              <input type="text" name="beritas[{{ $i }}][judul]" id="bulk-judul-{{ $i }}" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-xs focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Judul berita {{ $i + 1 }}">
            </div>

            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-gray-700">Link Berita Asli</label>
              <input type="url" name="beritas[{{ $i }}][link]" id="bulk-link-{{ $i }}"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-xs focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Link berita asli (opsional)">
            </div>

            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-gray-700">Isi Berita <span class="text-red-500">*</span></label>
              <textarea name="beritas[{{ $i }}][konten]" id="bulk-konten-{{ $i }}" rows="8" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 resize-y" placeholder="Isi berita lengkap..."></textarea>
            </div>
          </div>

          {{-- Meta --}}
          <div class="space-y-4">
            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-gray-700">Kategori</label>
              <select name="beritas[{{ $i }}][kategori_id]" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">— Tanpa Kategori —</option>
                @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                @endforeach
              </select>
            </div>

            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-gray-700">Tanggal Terbit <span class="text-red-500">*</span></label>
              <input type="date" name="beritas[{{ $i }}][tanggal]" value="{{ date('Y-m-d') }}" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-gray-700">URL Gambar (Otomatis / Manual)</label>
              <input type="url" name="beritas[{{ $i }}][gambar_url]" id="bulk-gambar-url-{{ $i }}"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-xs focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="URL gambar (opsional)">
              <div class="mt-2 hidden" id="bulk-preview-container-{{ $i }}">
                <img id="bulk-preview-img-{{ $i }}" src="" class="aspect-video w-full object-cover rounded-xl border border-gray-200">
              </div>
            </div>
          </div>
        </div>
      </div>
      @endfor
    </div>

    <div class="flex gap-3">
      <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold px-6 py-3 rounded-xl text-sm shadow transition-colors flex items-center gap-2">
        <i class="fas fa-save"></i> Terbitkan Semua Berita
      </button>
      <a href="{{ route('admin.beritas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-xl text-sm transition-colors">
        Batal
      </a>
    </div>
  </form>
</div>
@endif


{{-- Custom Modal Popup --}}
<div id="custom-modal" class="fixed inset-0 z-[999] flex items-end justify-center sm:items-center p-4 hidden" role="dialog" aria-modal="true">
  <div id="modal-backdrop" class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>
  <div id="modal-panel" class="relative bg-white rounded-2xl shadow-xl w-full max-w-xs p-5 transform translate-y-4 opacity-0 transition-all duration-300 ease-out">
    <div class="flex items-start gap-3">
      <div id="modal-icon-wrapper" class="flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center mt-0.5">
        <i id="modal-icon" class="text-base"></i>
      </div>
      <div class="flex-1 min-w-0">
        <h3 id="modal-title" class="text-sm font-bold text-gray-900 leading-snug"></h3>
        <p id="modal-message" class="text-xs text-gray-500 mt-1 leading-relaxed"></p>
      </div>
      <button onclick="closeModal()" class="flex-shrink-0 text-gray-300 hover:text-gray-500 transition-colors ml-1 mt-0.5">
        <i class="fas fa-times text-sm"></i>
      </button>
    </div>
    <div class="mt-4 flex justify-end">
      <button id="modal-ok-btn"
        class="px-5 py-1.5 rounded-lg font-semibold text-xs text-white transition-all hover:opacity-90 shadow-sm"
        onclick="closeModal()">
        OK, Mengerti
      </button>
    </div>
  </div>
</div>

<script>
// ---- Tab Switcher Gambar ----
function switchTab(tab) {
  const panelUpload = document.getElementById('panel-upload');
  const panelLink   = document.getElementById('panel-link');
  const tabUpload   = document.getElementById('tab-upload');
  const tabLinkBtn  = document.getElementById('tab-link');

  if (tab === 'upload') {
    panelUpload.classList.remove('hidden');
    panelLink.classList.add('hidden');
    tabUpload.classList.add('bg-white', 'text-teal-700', 'shadow-sm');
    tabUpload.classList.remove('text-gray-500');
    tabLinkBtn.classList.remove('bg-white', 'text-teal-700', 'shadow-sm');
    tabLinkBtn.classList.add('text-gray-500');
    document.getElementById('gambar-url-input').value = '';
  } else {
    panelLink.classList.remove('hidden');
    panelUpload.classList.add('hidden');
    tabLinkBtn.classList.add('bg-white', 'text-teal-700', 'shadow-sm');
    tabLinkBtn.classList.remove('text-gray-500');
    tabUpload.classList.remove('bg-white', 'text-teal-700', 'shadow-sm');
    tabUpload.classList.add('text-gray-500');
  }
}

// Preview gambar dari URL
document.getElementById('btn-preview-img-url').addEventListener('click', function() {
  const url = document.getElementById('gambar-url-input').value.trim();
  if (!url) return;
  const img = document.getElementById('preview-url-img');
  img.src = url;
  img.onload = () => document.getElementById('preview-url-container').classList.remove('hidden');
  img.onerror = () => showModal('error', 'Gagal Memuat Gambar', 'URL gambar tidak valid atau tidak dapat diakses.');
});

function showModal(type, title, message) {
  const modal    = document.getElementById('custom-modal');
  const backdrop = document.getElementById('modal-backdrop');
  const panel    = document.getElementById('modal-panel');
  const iconWrap = document.getElementById('modal-icon-wrapper');
  const icon     = document.getElementById('modal-icon');
  const btn      = document.getElementById('modal-ok-btn');

  document.getElementById('modal-title').textContent   = title;
  document.getElementById('modal-message').textContent = message;

  if (type === 'success') {
    iconWrap.className = 'flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center mt-0.5 bg-teal-100';
    icon.className     = 'text-base fas fa-check text-teal-600';
    btn.className      = 'px-5 py-1.5 rounded-lg font-semibold text-xs text-white transition-all hover:opacity-90 shadow-sm bg-teal-600';
  } else {
    iconWrap.className = 'flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center mt-0.5 bg-red-100';
    icon.className     = 'text-base fas fa-exclamation text-red-500';
    btn.className      = 'px-5 py-1.5 rounded-lg font-semibold text-xs text-white transition-all hover:opacity-90 shadow-sm bg-red-500';
  }

  modal.classList.remove('hidden');
  requestAnimationFrame(() => {
    backdrop.classList.replace('opacity-0', 'opacity-100');
    panel.classList.replace('translate-y-4', 'translate-y-0');
    panel.classList.replace('opacity-0', 'opacity-100');
  });
}

function closeModal() {
  const modal    = document.getElementById('custom-modal');
  const backdrop = document.getElementById('modal-backdrop');
  const panel    = document.getElementById('modal-panel');

  backdrop.classList.replace('opacity-100', 'opacity-0');
  panel.classList.replace('translate-y-0', 'translate-y-4');
  panel.classList.replace('opacity-100', 'opacity-0');
  setTimeout(() => modal.classList.add('hidden'), 300);
}

document.getElementById('modal-backdrop').addEventListener('click', closeModal);

// Tab Switcher Mode (Single / Bulk)
function switchMode(mode) {
  const sectionSingle = document.getElementById('section-single-upload');
  const sectionBulk   = document.getElementById('section-bulk-upload');
  const tabSingle     = document.getElementById('tab-mode-single');
  const tabBulk       = document.getElementById('tab-mode-bulk');

  if (mode === 'single') {
    sectionSingle.classList.remove('hidden');
    sectionBulk.classList.add('hidden');
    tabSingle.classList.add('bg-white', 'text-teal-700', 'shadow-sm');
    tabSingle.classList.remove('text-gray-500');
    tabBulk.classList.remove('bg-white', 'text-teal-700', 'shadow-sm');
    tabBulk.classList.add('text-gray-500');
  } else {
    sectionBulk.classList.remove('hidden');
    sectionSingle.classList.add('hidden');
    tabBulk.classList.add('bg-white', 'text-teal-700', 'shadow-sm');
    tabBulk.classList.remove('text-gray-500');
    tabSingle.classList.remove('bg-white', 'text-teal-700', 'shadow-sm');
    tabSingle.classList.add('text-gray-500');
  }
}

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

document.getElementById('btn-fetch-link').addEventListener('click', function() {
  const urlInput = document.getElementById('link-url-input').value.trim();
  if (!urlInput) {
    showModal('error', 'URL Kosong!', 'Silakan tempel (paste) URL link berita terlebih dahulu sebelum mengambil data.');
    return;
  }

  const spinner = document.getElementById('fetch-spinner');
  const btn = document.getElementById('btn-fetch-link');

  spinner.classList.add('fa-spin');
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-sync-alt fa-spin" id="fetch-spinner"></i> Mengambil data...';

  fetch('{{ route("admin.beritas.scrape") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ url: urlInput })
  })
  .then(response => {
    if (!response.ok) throw new Error('Gagal mengambil data. Pastikan URL valid dan dapat diakses.');
    return response.json();
  })
  .then(data => {
    if (data.success) {
      if (data.judul) document.querySelector('input[name="judul"]').value = data.judul;
      if (data.konten) document.querySelector('textarea[name="konten"]').value = data.konten;
      if (data.gambar_url) {
        document.getElementById('preview-img').src = data.gambar_url;
        document.getElementById('preview-container').classList.remove('hidden');
      }
      showModal('success', 'Berhasil!', 'Data berita (judul, isi, dan gambar) berhasil diambil otomatis dari link berita.');
    }
  })
  .catch(error => {
    showModal('error', 'Gagal Mengambil Data', error.message);
  })
  .finally(() => {
    document.getElementById('fetch-spinner')?.classList.remove('fa-spin');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-sync-alt" id="fetch-spinner"></i> Ambil Data Link';
  });
});

// Bulk Fetching Logic
const btnFetchBulk = document.getElementById('btn-fetch-bulk');
if (btnFetchBulk) {
  btnFetchBulk.addEventListener('click', function() {
    const urls = [
      document.getElementById('bulk-url-input-0').value.trim(),
      document.getElementById('bulk-url-input-1').value.trim(),
      document.getElementById('bulk-url-input-2').value.trim()
    ];

    const hasUrls = urls.some(url => url !== '');
    if (!hasUrls) {
      showModal('error', 'URL Kosong!', 'Masukkan setidaknya 1 link berita untuk diambil datanya.');
      return;
    }

    const spinner = document.getElementById('fetch-spinner-bulk');
    spinner.classList.add('fa-spin');
    btnFetchBulk.disabled = true;
    btnFetchBulk.innerHTML = '<i class="fas fa-sync-alt fa-spin" id="fetch-spinner-bulk"></i> Mengambil data...';

    const promises = urls.map((url, index) => {
      if (!url) return Promise.resolve({ skipped: true });

      const badge = document.getElementById(`bulk-status-badge-${index}`);
      badge.textContent = 'Sedang Mengambil Data...';
      badge.className = 'text-[10px] bg-yellow-100 text-yellow-700 font-bold px-2.5 py-1 rounded-full';

      return fetch('{{ route("admin.beritas.scrape") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ url: url })
      })
      .then(response => {
        if (!response.ok) throw new Error('Koneksi gagal atau website memblokir.');
        return response.json();
      })
      .then(data => {
        if (data.success) {
          document.getElementById(`bulk-judul-${index}`).value      = data.judul || '';
          document.getElementById(`bulk-konten-${index}`).value     = data.konten || '';
          document.getElementById(`bulk-link-${index}`).value       = url;
          document.getElementById(`bulk-gambar-url-${index}`).value = data.gambar_url || '';

          if (data.gambar_url) {
            document.getElementById(`bulk-preview-img-${index}`).src = data.gambar_url;
            document.getElementById(`bulk-preview-container-${index}`).classList.remove('hidden');
          }

          badge.textContent = 'Berhasil Diambil';
          badge.className = 'text-[10px] bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded-full';
          return { success: true };
        } else {
          throw new Error(data.message || 'Gagal mengekstrak data.');
        }
      })
      .catch(error => {
        badge.textContent = 'Gagal: ' + error.message;
        badge.className = 'text-[10px] bg-red-100 text-red-700 font-bold px-2.5 py-1 rounded-full';
        return { success: false, error: error.message };
      });
    });

    Promise.all(promises).then(results => {
      const successfulCount = results.filter(r => r.success).length;
      const failedCount = results.filter(r => r.success === false).length;

      if (successfulCount > 0) {
        showModal('success', 'Pengambilan Selesai!', `${successfulCount} berita berhasil diambil secara otomatis. Silakan periksa detailnya.`);
      } else if (failedCount > 0) {
        showModal('error', 'Semua Pengambilan Gagal', 'Gagal mengambil data dari link yang dimasukkan.');
      }
    })
    .finally(() => {
      spinner.classList.remove('fa-spin');
      btnFetchBulk.disabled = false;
      btnFetchBulk.innerHTML = '<i class="fas fa-sync-alt" id="fetch-spinner-bulk"></i> Ambil Semua Data Link';
    });
  });
}
</script>
@endsection
