@extends('layouts.admin')
@section('title', $dosen ? 'Edit Dosen' : 'Tambah Dosen')
@section('breadcrumb', 'Dosen Ekonomi Syariah / ' . ($dosen ? 'Edit' : 'Tambah Baru'))

@section('content')
<div class="max-w-2xl">
  <form action="{{ $dosen ? route('admin.dosens.update', $dosen) : route('admin.dosens.store') }}"
        method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($dosen) @method('PUT') @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">

      {{-- Foto preview --}}
      @if($dosen && $dosen->foto)
      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Foto Saat Ini</label>
        <div class="w-24 h-32 rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
          <img src="{{ str_starts_with($dosen->foto, 'http') ? $dosen->foto : asset('storage/' . $dosen->foto) }}"
               alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
        </div>
      </div>
      @endif

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
        <input type="text" name="nama" value="{{ old('nama', $dosen?->nama) }}" required
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
          placeholder="Contoh: Abdul Rochman, M.Pd">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Gelar Depan</label>
          <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $dosen?->gelar_depan) }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Contoh: Drs. H.">
        </div>
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Gelar Belakang</label>
          <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $dosen?->gelar_belakang) }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Contoh: M.M.">
        </div>
      </div>

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Jabatan</label>
        <input type="text" name="jabatan" value="{{ old('jabatan', $dosen?->jabatan ?? 'Dosen Ekonomi Syariah') }}"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
          placeholder="Contoh: Ketua Program Studi">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Program Studi</label>
          <input type="text" name="prodi" value="{{ old('prodi', $dosen?->prodi ?? 'Ekonomi Syariah') }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Contoh: Ekonomi Syariah">
        </div>
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Jenis Pegawai / Status</label>
          <input type="text" name="jenis_pegawai" value="{{ old('jenis_pegawai', $dosen?->jenis_pegawai ?? 'Dosen Tetap | Aktif Mengajar') }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Contoh: Dosen Tetap | Aktif Mengajar">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">NIDN</label>
          <input type="text" name="nidn" value="{{ old('nidn', $dosen?->nidn) }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Contoh: 2107039402">
        </div>
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">NUPTK</label>
          <input type="text" name="nupkt" value="{{ old('nupkt', $dosen?->nupkt) }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Contoh: 8639772673130292">
        </div>
      </div>

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">URL Google Scholar</label>
        <input type="url" name="google_scholar" value="{{ old('google_scholar', $dosen?->google_scholar) }}"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
          placeholder="https://scholar.google.com/citations?user=...">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Email</label>
          <input type="email" name="email" value="{{ old('email', $dosen?->email) }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Contoh: rochman.02@gmail.com">
        </div>
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Pendidikan Terakhir</label>
          <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $dosen?->pendidikan_terakhir) }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            placeholder="Contoh: S-2">
        </div>
      </div>


      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Upload Foto <span class="text-gray-400">(opsional, maks 3MB)</span></label>
        <input type="file" name="foto" accept="image/*" id="foto-input"
          class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold hover:file:bg-teal-100">
        <div id="preview-container" class="hidden mt-2">
          <img id="preview-img" src="" alt="Preview" class="w-24 h-32 object-cover rounded-xl border border-gray-200">
        </div>
      </div>

      <div class="space-y-1.5">
        <label class="text-sm font-semibold text-gray-700">Atau URL Foto Eksternal</label>
        <input type="url" name="foto_url" value="{{ old('foto_url', $dosen && str_starts_with($dosen->foto ?? '', 'http') ? $dosen->foto : '') }}"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
          placeholder="https://...">
        <p class="text-xs text-gray-400">Jika diisi, URL akan digunakan (abaikan jika sudah upload foto).</p>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Urutan Tampil</label>
          <input type="number" name="urutan" value="{{ old('urutan', $dosen?->urutan ?? 0) }}" min="0"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Status</label>
          <select name="aktif" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="1" {{ old('aktif', $dosen?->aktif ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('aktif', $dosen?->aktif) == 0 ? 'selected' : '' }}>Nonaktif</option>
          </select>
        </div>
      </div>
    </div>

    <div class="flex gap-3">
      <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow transition-colors flex items-center gap-2">
        <i class="fas fa-save"></i> {{ $dosen ? 'Perbarui Data' : 'Simpan Dosen' }}
      </button>
      <a href="{{ route('admin.dosens.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
        Batal
      </a>
    </div>
  </form>
</div>

<script>
document.getElementById('foto-input').addEventListener('change', function(e) {
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