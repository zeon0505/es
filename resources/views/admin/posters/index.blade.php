@extends('layouts.admin')
@section('title', 'Poster & Pengumuman')
@section('breadcrumb', 'Kelola poster dan flyer pengumuman Ekonomi Syariah')
@section('header-action')
  <a href="{{ route('admin.posters.create') }}" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold px-4 py-2 rounded-xl transition-colors shadow">
    <i class="fas fa-plus"></i> Tambah Poster
  </a>
@endsection

@section('content')
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
  @forelse($posters as $poster)
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all group">
    {{-- Gambar / Placeholder --}}
    <div class="aspect-[3/4] w-full bg-gradient-to-br from-teal-600 to-teal-800 relative overflow-hidden">
      @if($poster->gambar)
      <img src="{{ asset('storage/' . $poster->gambar) }}" alt="{{ $poster->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
      @else
      <div class="absolute inset-0 flex flex-col items-center justify-center text-white/60 text-center p-4">
        <i class="fas fa-flag text-3xl mb-2"></i>
        <span class="text-xs font-semibold leading-tight">{{ $poster->judul }}</span>
      </div>
      @endif
      {{-- Status badge --}}
      <span class="absolute top-2 right-2 text-[10px] font-bold px-2 py-0.5 rounded-full {{ $poster->aktif ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
        {{ $poster->aktif ? 'Aktif' : 'Nonaktif' }}
      </span>
    </div>

    <div class="p-4 space-y-1">
      <p class="font-bold text-gray-800 text-sm leading-tight truncate">{{ $poster->judul }}</p>
      <span class="text-[11px] text-teal-600 font-semibold">{{ $poster->kategori }}</span>
      @if($poster->deskripsi)
      <p class="text-xs text-gray-500 truncate">{{ $poster->deskripsi }}</p>
      @endif
    </div>

    <div class="px-4 pb-4 flex gap-2">
      <a href="{{ route('admin.posters.edit', $poster) }}" class="flex-1 text-center text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 py-1.5 rounded-lg transition-all">
        <i class="fas fa-pen text-[10px]"></i> Edit
      </a>
      <form action="{{ route('admin.posters.destroy', $poster) }}" method="POST" class="flex-1">
        @csrf @method('DELETE')
        <button type="button" onclick="confirmDelete(this.closest('form'), '{{ addslashes($poster->judul) }}')" class="w-full text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 py-1.5 rounded-lg transition-all">
          <i class="fas fa-trash text-[10px]"></i> Hapus
        </button>
      </form>
    </div>
  </div>
  @empty
  <div class="col-span-full py-16 text-center text-gray-400">
    <i class="fas fa-flag text-4xl mb-3 block opacity-30"></i>
    <p class="text-sm">Belum ada poster.</p>
    <a href="{{ route('admin.posters.create') }}" class="text-teal-700 font-semibold text-sm hover:underline mt-1 inline-block">Tambah sekarang</a>
  </div>
  @endforelse
</div>
@endsection
