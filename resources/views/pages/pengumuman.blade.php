@extends('layouts.app')
@section('title', 'Poster & Pengumuman - Prodi ES STAIMAS')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

  @if(isset($posters) && $posters->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
      @foreach($posters as $poster)
      <a href="{{ route('pages.pengumuman.show', $poster->slug ?? $poster->id) }}"
         class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col">

        {{-- Gambar Poster --}}
        <div class="relative aspect-[3/4] bg-slate-900 overflow-hidden">
          @if($poster->gambar)
            <img src="{{ asset('storage/' . $poster->gambar) }}"
                 alt="{{ $poster->judul }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
          @else
            <div class="w-full h-full flex flex-col items-center justify-center text-slate-500 space-y-2">
              <i class="fas fa-image text-3xl"></i>
              <span class="text-xs font-semibold">Tanpa Gambar</span>
            </div>
          @endif

          {{-- Badge Kategori --}}
          <span class="absolute top-2 left-2 bg-teal-700/90 backdrop-blur text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
            {{ $poster->kategori ?? 'Umum' }}
          </span>

          {{-- Hover Overlay --}}
          <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-white/90 text-teal-800 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
              <i class="fas fa-eye text-[10px]"></i> Lihat Detail
            </span>
          </div>
        </div>

        {{-- Info Singkat --}}
        <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between gap-1.5">
          <h3 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-teal-700 transition-colors line-clamp-2 leading-snug">
            {{ $poster->judul }}
          </h3>
          @if($poster->deskripsi)
          <p class="text-[11px] text-gray-400 line-clamp-2 leading-relaxed">{{ $poster->deskripsi }}</p>
          @endif
          <span class="text-[10px] font-semibold text-gray-300 mt-1">
            {{ $poster->created_at->format('d M Y') }}
          </span>
        </div>
      </a>
      @endforeach
    </div>
  @else
    <div class="bg-white rounded-2xl border border-gray-100 p-16 flex flex-col items-center justify-center text-center space-y-3">
      <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center">
        <i class="fas fa-bullhorn text-2xl text-gray-300"></i>
      </div>
      <h3 class="font-bold text-gray-500">Belum ada pengumuman</h3>
      <p class="text-sm text-gray-400">Pengumuman resmi program studi ES akan ditampilkan di sini.</p>
    </div>
  @endif

</div>
@endsection
