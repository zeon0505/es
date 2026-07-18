@extends('layouts.app')

@section('content')
<div class="space-y-8">

  {{-- Filter Kategori --}}
  <div class="flex flex-wrap gap-3 items-center">
    <span class="text-sm font-semibold text-gray-600">Kategori:</span>
    <a href="{{ route('pages.berita') }}" class="px-4 py-1.5 text-xs font-bold rounded-full {{ !request('kategori') ? 'bg-teal-700 text-white' : 'bg-gray-100 text-gray-600 hover:bg-teal-50 hover:text-teal-700' }} transition-colors">Semua</a>
    @foreach($kategoris as $kat)
    <a href="{{ route('pages.berita', ['kategori' => $kat->slug]) }}"
       class="px-4 py-1.5 text-xs font-bold rounded-full {{ request('kategori') == $kat->slug ? 'bg-teal-700 text-white' : 'bg-gray-100 text-gray-600 hover:bg-teal-50 hover:text-teal-700' }} transition-colors">
      {{ $kat->nama }}
    </a>
    @endforeach
  </div>

  {{-- Berita Utama (Featured) --}}
  @if($beritas->isNotEmpty())
  @php $featured = $beritas->first(); @endphp
  <a href="{{ route('pages.berita.show', $featured->slug) }}" class="group block bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all">
    <div class="grid grid-cols-1 md:grid-cols-2">
      <div class="aspect-video md:aspect-auto min-h-[220px] relative overflow-hidden bg-gradient-to-br from-teal-700 to-teal-900">
        @if($featured->gambar)
        <img src="{{ asset('storage/' . $featured->gambar) }}" alt="{{ $featured->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
        <div class="absolute inset-0 flex flex-col items-center justify-center text-teal-200 text-center p-8">
          <i class="fas fa-newspaper text-5xl mb-3 opacity-30"></i>
          <p class="text-sm font-semibold">{{ $featured->judul }}</p>
        </div>
        @endif
        <span class="absolute top-4 left-4 bg-yellow-500 text-gray-900 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">Unggulan</span>
      </div>
      <div class="p-8 flex flex-col justify-between space-y-4">
        <div class="space-y-3">
          <div class="flex items-center gap-3">
            @if($featured->kategori)
            <span class="text-[11px] font-bold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full">{{ $featured->kategori->nama }}</span>
            @endif
            <span class="text-xs text-gray-400">{{ $featured->tanggal->isoFormat('D MMMM Y') }}</span>
          </div>
          <h2 class="text-xl font-extrabold text-gray-800 leading-snug group-hover:text-teal-700 transition-colors">{{ $featured->judul }}</h2>
          <p class="text-sm text-gray-500 leading-relaxed">{{ Str::limit(strip_tags($featured->konten), 160) }}</p>
        </div>
        <div class="flex items-center gap-2 text-sm font-bold text-teal-700 group-hover:gap-4 transition-all">
          Baca Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
        </div>
      </div>
    </div>
  </a>

  {{-- Grid Berita Lainnya --}}
  @if($beritas->count() > 1)
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($beritas->skip(1) as $berita)
    <a href="{{ route('pages.berita.show', $berita->slug) }}" class="group bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col">
      <div class="aspect-video bg-gradient-to-br from-teal-600 to-teal-800 relative overflow-hidden">
        @if($berita->gambar)
        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
        <div class="absolute inset-0 flex items-center justify-center"><i class="fas fa-newspaper text-4xl text-white/20"></i></div>
        @endif
        @if($berita->kategori)
        <span class="absolute top-3 left-3 text-[10px] font-bold bg-white/20 text-white px-2.5 py-0.5 rounded-full backdrop-blur-sm">{{ $berita->kategori->nama }}</span>
        @endif
      </div>
      <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
        <div class="space-y-2">
          <span class="text-xs text-gray-400">{{ $berita->tanggal->isoFormat('D MMMM Y') }}</span>
          <h3 class="font-bold text-gray-800 text-sm leading-snug group-hover:text-teal-700 transition-colors">{{ $berita->judul }}</h3>
          <p class="text-xs text-gray-500 leading-relaxed">{{ Str::limit(strip_tags($berita->konten), 90) }}</p>
        </div>
        <span class="text-xs font-bold text-teal-700 flex items-center gap-1 group-hover:gap-2 transition-all">Baca Selengkapnya <i class="fas fa-arrow-right text-[10px]"></i></span>
      </div>
    </a>
    @endforeach
  </div>
  @endif

  @else
  <div class="py-20 text-center text-gray-400 bg-white rounded-2xl border border-gray-100">
    <i class="fas fa-newspaper text-4xl mb-3 block opacity-30"></i>
    <p class="text-sm">Belum ada berita yang dipublikasikan.</p>
  </div>
  @endif

  {{-- Poster / Flyer Section --}}
  @if($posters->isNotEmpty())
  <div class="space-y-4">
    <h3 class="font-bold text-gray-800 text-lg">Poster & Pengumuman</h3>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
      @foreach($posters as $poster)
      <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer group">
        <div class="aspect-[3/4] w-full bg-gradient-to-br from-teal-600 to-teal-800 relative overflow-hidden">
          @if($poster->gambar)
          <img src="{{ asset('storage/' . $poster->gambar) }}" alt="{{ $poster->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          @else
          <div class="absolute inset-0 flex flex-col items-center justify-center text-white/60 text-center p-4">
            <i class="fas fa-flag text-3xl mb-2"></i>
            <span class="text-xs font-semibold leading-tight">{{ $poster->judul }}</span>
          </div>
          @endif
        </div>
        <div class="p-3">
          <p class="text-xs font-bold text-gray-800 leading-snug truncate">{{ $poster->judul }}</p>
          @if($poster->deskripsi)<p class="text-[11px] text-gray-500 leading-snug mt-0.5 truncate">{{ $poster->deskripsi }}</p>@endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

</div>
@endsection
