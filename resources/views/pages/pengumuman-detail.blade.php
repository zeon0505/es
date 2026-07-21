@extends('layouts.app')
@section('title', $poster->judul . ' - Prodi ES STAIMAS')

@section('content')
<div class="max-w-6xl mx-auto py-4 px-2 sm:px-4 space-y-10">

  <div class="bg-white rounded-3xl border border-gray-200/80 shadow-xl shadow-gray-100/70 overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[480px]">

      {{-- Media Kiri --}}
      <div class="lg:col-span-7 bg-slate-950 p-4 sm:p-6 flex items-center justify-center relative min-h-[350px] lg:min-h-[500px]">
        @if($poster->gambar)
          <img src="{{ asset('storage/' . $poster->gambar) }}"
               alt="{{ $poster->judul }}"
               class="max-h-[600px] w-auto max-w-full object-contain rounded-xl shadow-2xl" />
        @else
          <div class="flex flex-col items-center justify-center text-slate-500 py-16 space-y-2">
            <i class="fas fa-image text-4xl"></i>
            <span class="text-xs font-semibold">Tidak ada gambar poster</span>
          </div>
        @endif
        <span class="absolute top-4 left-4 bg-teal-700/90 backdrop-blur-md text-white text-[11px] font-bold px-3 py-1 rounded-full shadow">
          {{ $poster->kategori ?? 'Pengumuman' }}
        </span>
      </div>

      {{-- Detail Kanan --}}
      <div class="lg:col-span-5 p-6 sm:p-8 flex flex-col justify-between space-y-6 bg-white border-t lg:border-t-0 lg:border-l border-gray-100">
        <div class="space-y-5">

          <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
            <div class="w-10 h-10 rounded-full bg-teal-50 border border-teal-500/30 p-0.5 flex items-center justify-center shrink-0">
              <img src="{{ asset('assest/Logo es.png') }}" alt="ES Logo" class="w-full h-full object-contain rounded-full">
            </div>
            <div class="leading-tight">
              <div class="flex items-center gap-1.5">
                <span class="font-extrabold text-gray-900 text-sm">prodies_staimas</span>
                <i class="fas fa-check-circle text-teal-600 text-xs"></i>
              </div>
              <span class="text-[11px] text-gray-400 font-medium block">Prodi ES &bull; {{ $poster->created_at->isoFormat('D MMMM Y') }}</span>
            </div>
          </div>

          <div class="space-y-3">
            <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 leading-snug tracking-tight">{{ $poster->judul }}</h1>
            @if($poster->deskripsi)
            <div class="text-xs font-medium text-teal-800 bg-teal-50/80 p-3 rounded-xl border border-teal-100 leading-relaxed">
              <i class="fas fa-info-circle text-teal-600 mr-1"></i> {{ $poster->deskripsi }}
            </div>
            @endif
          </div>

          @if($poster->konten)
          <div class="text-xs sm:text-sm text-gray-700 leading-relaxed whitespace-pre-line pt-3 border-t border-gray-100 max-h-[300px] overflow-y-auto pr-2">
            {!! nl2br(e($poster->konten)) !!}
          </div>
          @endif
        </div>

        <div class="pt-4 border-t border-gray-100 space-y-3">
          <div class="grid grid-cols-2 gap-3">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($poster->judul . ' - ' . url()->current()) }}"
               target="_blank"
               class="flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-colors shadow-sm">
              <i class="fab fa-whatsapp text-sm"></i> Bagikan WA
            </a>
            <button onclick="copyCurrentUrl()"
                    class="flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-4 rounded-xl text-xs transition-colors">
              <i class="fas fa-link text-xs"></i> <span id="copy-btn-text">Salin Tautan</span>
            </button>
          </div>
          @if($poster->gambar)
            <a href="{{ asset('storage/' . $poster->gambar) }}" download
               class="w-full flex items-center justify-center gap-2 border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-2 rounded-xl text-xs transition-colors">
              <i class="fas fa-download"></i> Unduh Poster File
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div id="toast-copy" class="fixed bottom-6 right-6 bg-gray-900/90 text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-lg flex items-center gap-2 opacity-0 pointer-events-none transition-all duration-300 z-50">
    <i class="fas fa-check-circle text-emerald-400"></i> Link berhasil disalin!
  </div>

  @if(isset($otherPosters) && $otherPosters->count() > 0)
  <div class="pt-6 border-t border-gray-200/80 space-y-5">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fas fa-th-large text-teal-700"></i>
        <h3 class="text-base font-extrabold text-gray-900">Poster & Pengumuman Lainnya</h3>
      </div>
      <a href="{{ route('pages.pengumuman') }}" class="text-xs font-bold text-teal-700 hover:underline">
        Lihat Semua <i class="fas fa-arrow-right text-[10px] ml-1"></i>
      </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
      @foreach($otherPosters as $item)
      <a href="{{ route('pages.pengumuman.show', $item->slug ?? $item->id) }}"
         class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col">
        <div class="aspect-[3/4] bg-slate-900 relative overflow-hidden">
          @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
          @else
            <div class="w-full h-full flex flex-col items-center justify-center text-slate-500 p-2 text-center">
              <i class="fas fa-image text-2xl mb-1"></i>
            </div>
          @endif
          <span class="absolute top-2 left-2 bg-black/60 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $item->kategori ?? 'Umum' }}</span>
          <div class="absolute inset-0 bg-black/0 group-hover:bg-black/35 transition-all duration-200 flex items-center justify-center">
            <span class="text-white text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity bg-white/20 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1">
              <i class="fas fa-eye text-[10px]"></i> Lihat
            </span>
          </div>
        </div>
        <div class="p-3.5 flex-1 flex flex-col justify-between">
          <h4 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-teal-700 transition-colors line-clamp-2 leading-snug">{{ $item->judul }}</h4>
          <span class="text-[10px] font-semibold text-gray-400 mt-2 block">{{ $item->created_at->format('d M Y') }}</span>
        </div>
      </a>
      @endforeach
    </div>
  </div>
  @endif

</div>
<script>
function copyCurrentUrl() {
  navigator.clipboard.writeText(window.location.href).then(() => {
    const toast = document.getElementById('toast-copy');
    toast.classList.remove('opacity-0', 'pointer-events-none');
    toast.classList.add('opacity-100');
    setTimeout(() => { toast.classList.remove('opacity-100'); toast.classList.add('opacity-0', 'pointer-events-none'); }, 2000);
  });
}
</script>
@endsection
