@extends('layouts.app')

@section('content')
<div class="space-y-10">

  <p class="text-gray-500 text-sm text-center">Program Studi Ekonomi Syariah STAIMAS Wonogiri didukung oleh tenaga pengajar yang berkualifikasi dan berdedikasi tinggi.</p>

  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($dosens as $dosen)
    <a href="{{ route('pages.dosen.show', $dosen) }}" class="block bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all group text-center">
      <div class="aspect-[3/4] w-full overflow-hidden bg-gray-100">
        @if($dosen->foto)
        <img src="{{ str_starts_with($dosen->foto, 'http') ? $dosen->foto : asset('storage/' . $dosen->foto) }}"
             alt="{{ $dosen->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
        <div class="w-full h-full bg-teal-100 flex items-center justify-center"><i class="fas fa-user text-teal-400 text-4xl"></i></div>
        @endif
      </div>
      <div class="p-4 space-y-1">
        <h4 class="font-bold text-gray-800 text-sm leading-snug group-hover:text-teal-700 transition-colors">{{ $dosen->nama }}</h4>
        <span class="inline-block text-[11px] font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-full">{{ $dosen->jabatan }}</span>
      </div>
    </a>
    @empty
    <div class="col-span-4 py-16 text-center text-gray-400">
      <i class="fas fa-user-tie text-4xl mb-2 block opacity-30"></i>
      <p class="text-sm">Belum ada data dosen.</p>
    </div>
    @endforelse
  </div>

  {{-- CTA --}}
  <div class="bg-gradient-to-br from-teal-800 to-teal-900 rounded-3xl p-8 text-center text-white space-y-4">
    <h3 class="text-2xl font-black">Bergabunglah dengan Keluarga Ekonomi Syariah STAIMAS</h3>
    <p class="text-teal-100 text-sm max-w-lg mx-auto">Belajar di bawah bimbingan para pengajar berpengalaman yang siap menginspirasi dan mendampingi perjalanan akademismu.</p>
    <a href="https://staimaswonogiri.ecampuz.com/eadmisi/" target="_blank" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-gray-950 font-bold px-6 py-3 rounded-xl text-sm transition-all shadow-md">
      <i class="fas fa-user-plus"></i> Daftar PMB 2025
    </a>
  </div>

</div>
@endsection