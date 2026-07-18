@extends('layouts.admin')
@section('title', 'Berita Ekonomi Syariah')
@section('breadcrumb', 'Kelola semua berita dan artikel Program Studi Ekonomi Syariah')
@section('header-action')
  <a href="{{ route('admin.beritas.create') }}" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold px-4 py-2 rounded-xl transition-colors shadow">
    <i class="fas fa-plus"></i> Tulis Berita
  </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[800px]">
      <thead class="bg-gray-50 border-b border-gray-100">
      <tr>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Gambar</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Judul</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Kategori</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
        <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-50">
      @forelse($beritas as $berita)
      <tr class="hover:bg-gray-50/50">
        <td class="px-6 py-3">
          <div class="w-16 h-10 rounded-lg overflow-hidden bg-teal-100 flex items-center justify-center">
            @if($berita->gambar)
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
            @else
            <i class="fas fa-newspaper text-teal-400 text-xs"></i>
            @endif
          </div>
        </td>
        <td class="px-6 py-3">
          <p class="font-semibold text-gray-800 max-w-xs truncate">{{ $berita->judul }}</p>
          <p class="text-[11px] text-gray-400 mt-0.5 truncate max-w-xs">{{ Str::limit(strip_tags($berita->konten), 60) }}</p>
        </td>
        <td class="px-6 py-3">
          @if($berita->kategori)
          <span class="text-[11px] font-bold bg-teal-50 text-teal-700 px-2.5 py-1 rounded-full">{{ $berita->kategori->nama }}</span>
          @else
          <span class="text-[11px] text-gray-400">—</span>
          @endif
        </td>
        <td class="px-6 py-3 text-gray-500 text-xs">{{ $berita->tanggal->format('d M Y') }}</td>
        <td class="px-6 py-3">
          <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $berita->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
            {{ $berita->aktif ? 'Aktif' : 'Draft' }}
          </span>
        </td>
        <td class="px-6 py-3 text-right">
          <div class="flex items-center justify-end gap-2">
            <a href="{{ route('pages.berita.show', $berita->slug) }}" target="_blank"
               class="text-xs font-semibold text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-3 py-1.5 rounded-lg transition-all">
              <i class="fas fa-eye text-[10px]"></i>
            </a>
            <a href="{{ route('admin.beritas.edit', $berita) }}" class="text-xs font-semibold text-teal-700 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg transition-all">
              <i class="fas fa-pen text-[10px]"></i> Edit
            </a>
            <form action="{{ route('admin.beritas.destroy', $berita) }}" method="POST">
              @csrf @method('DELETE')
              <button type="button" onclick="confirmDelete(this.closest('form'), '{{ addslashes($berita->judul) }}')" class="text-xs font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-all">
                <i class="fas fa-trash text-[10px]"></i> Hapus
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">
        <i class="fas fa-newspaper text-3xl mb-2 block opacity-30"></i>
        Belum ada berita. <a href="{{ route('admin.beritas.create') }}" class="text-teal-700 font-semibold">Tulis sekarang</a>
      </td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection