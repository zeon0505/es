@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- KOLOM KIRI (UTAMA) --}}
    <div class="lg:col-span-2 space-y-6">
      
      {{-- Card Berita --}}
      <article class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        {{-- Gambar / Hero --}}
        <div class="aspect-video w-full bg-gradient-to-br from-teal-700 to-teal-900 relative overflow-hidden">
          @if($berita->gambar)
          <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
          @else
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white p-8 space-y-2">
              <i class="fas fa-newspaper text-6xl text-teal-300 opacity-30 mb-4 block"></i>
              <h1 class="text-xl sm:text-2xl font-black leading-tight px-4">{{ $berita->judul }}</h1>
            </div>
          </div>
          @endif
        </div>

        {{-- Meta --}}
        <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center gap-4 text-xs sm:text-sm">
          @if($berita->kategori)
          <span class="text-[11px] font-bold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full">{{ $berita->kategori->nama }}</span>
          @endif
          <div class="flex items-center gap-2 text-gray-500">
            <i class="fas fa-calendar-alt text-teal-600"></i>
            <span>{{ $berita->tanggal->isoFormat('dddd, D MMMM Y') }}</span>
          </div>
          <div class="flex items-center gap-2 text-gray-500">
            <i class="fas fa-user text-teal-600"></i>
            <span>Redaksi Ekonomi Syariah</span>
          </div>
        </div>

        {{-- Isi Konten --}}
        <div class="p-6 sm:p-8 space-y-6">
          @if($berita->gambar)
          <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">{{ $berita->judul }}</h1>
          @endif

          <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed space-y-4">
            @foreach(explode("\n", $berita->konten) as $paragraph)
              @if(trim($paragraph))
              <p>{{ trim($paragraph) }}</p>
              @endif
            @endforeach
          </div>

          <blockquote class="border-l-4 border-teal-600 bg-teal-50 rounded-r-2xl px-6 py-4 my-4">
            <p class="text-teal-800 text-sm font-semibold italic leading-relaxed">
              "Kami terus berkomitmen memajukan kualitas lulusan Ekonomi Syariah STAIMAS Wonogiri yang berakhlak mulia dan profesional."
            </p>
            <footer class="text-xs text-teal-600 font-bold mt-2">— Kaprodi Ekonomi Syariah STAIMAS</footer>
          </blockquote>
        </div>
      </article>

      {{-- Navigasi Post Sebelumnya & Selanjutnya --}}
      <div class="grid grid-cols-2 gap-4 bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
        <div>
          @if($prev)
          <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">← Post Sebelumnya</span>
          <a href="{{ route('pages.berita.show', $prev->slug) }}" class="text-xs sm:text-sm font-bold text-teal-700 hover:text-teal-900 line-clamp-2 mt-1.5 transition-colors">
            {{ $prev->judul }}
          </a>
          @else
          <span class="text-[10px] font-bold text-gray-300 block uppercase tracking-wider">← Post Sebelumnya</span>
          <span class="text-xs sm:text-sm text-gray-400 block mt-1.5">Tidak ada berita sebelumnya</span>
          @endif
        </div>
        <div class="text-right border-l border-gray-100 pl-4">
          @if($next)
          <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Post Selanjutnya →</span>
          <a href="{{ route('pages.berita.show', $next->slug) }}" class="text-xs sm:text-sm font-bold text-teal-700 hover:text-teal-900 line-clamp-2 mt-1.5 transition-colors">
            {{ $next->judul }}
          </a>
          @else
          <span class="text-[10px] font-bold text-gray-300 block uppercase tracking-wider">Post Selanjutnya →</span>
          <span class="text-xs sm:text-sm text-gray-400 block mt-1.5">Tidak ada berita selanjutnya</span>
          @endif
        </div>
      </div>

      {{-- Share & Back --}}
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50 border border-gray-200/60 rounded-2xl p-5">
        <a href="{{ route('pages.berita') }}" class="flex items-center gap-2 text-sm font-bold text-teal-700 hover:text-teal-900 transition-colors">
          <i class="fas fa-arrow-left text-xs"></i> Kembali ke Berita
        </a>
        <div class="flex items-center gap-3">
          <span class="text-xs text-gray-400 font-semibold">Bagikan:</span>
          <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank"
             class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors text-xs">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . request()->fullUrl()) }}" target="_blank"
             class="w-8 h-8 rounded-lg bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition-colors text-xs">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="https://twitter.com/intent/tweet?text={{ urlencode($berita->judul) }}&url={{ urlencode(request()->fullUrl()) }}" target="_blank"
             class="w-8 h-8 rounded-lg bg-gray-800 text-white flex items-center justify-center hover:bg-gray-900 transition-colors text-xs">
            <i class="fab fa-x-twitter"></i>
          </a>
        </div>
      </div>

    </div>

    {{-- KOLOM KANAN (SIDEBAR) --}}
    <div class="space-y-6">

      {{-- Box: Berita Terkait (Kategori Sama) --}}
      @if($related->isNotEmpty())
      <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
        <h3 class="font-extrabold text-gray-800 text-sm border-b border-gray-100 pb-3 flex items-center gap-2">
          <span class="w-1.5 h-4 bg-teal-700 rounded-full"></span>
          Berita Terkait
        </h3>
        <div class="space-y-3">
          @foreach($related as $rel)
          <a href="{{ route('pages.berita.show', $rel->slug) }}" class="group flex gap-3 items-start hover:bg-gray-50 p-2 rounded-xl transition-colors">
            <div class="w-16 h-12 rounded-lg overflow-hidden bg-teal-150 flex-shrink-0">
              @if($rel->gambar)
              <img src="{{ asset('storage/' . $rel->gambar) }}" alt="{{ $rel->judul }}" class="w-full h-full object-cover">
              @else
              <div class="w-full h-full flex items-center justify-center bg-teal-50"><i class="fas fa-newspaper text-teal-400 text-sm"></i></div>
              @endif
            </div>
            <div class="min-w-0">
              <span class="text-[10px] text-gray-400 block">{{ $rel->tanggal->isoFormat('D MMM Y') }}</span>
              <h4 class="text-xs font-bold text-gray-800 leading-snug group-hover:text-teal-700 transition-colors line-clamp-2 mt-0.5">{{ $rel->judul }}</h4>
            </div>
          </a>
          @endforeach
        </div>
      </div>
      @endif

      {{-- Box: Berita Lainnya (Terbaru) --}}
      <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
        <h3 class="font-extrabold text-gray-800 text-sm border-b border-gray-100 pb-3 flex items-center gap-2">
          <span class="w-1.5 h-4 bg-yellow-500 rounded-full"></span>
          Berita Terbaru Lainnya
        </h3>
        <div class="space-y-3">
          @forelse($otherBeritas as $other)
          <a href="{{ route('pages.berita.show', $other->slug) }}" class="group flex gap-3 items-start hover:bg-gray-50 p-2 rounded-xl transition-colors">
            <div class="w-16 h-12 rounded-lg overflow-hidden bg-teal-150 flex-shrink-0">
              @if($other->gambar)
              <img src="{{ asset('storage/' . $other->gambar) }}" alt="{{ $other->judul }}" class="w-full h-full object-cover">
              @else
              <div class="w-full h-full flex items-center justify-center bg-teal-50"><i class="fas fa-newspaper text-teal-400 text-sm"></i></div>
              @endif
            </div>
            <div class="min-w-0">
              <span class="text-[10px] text-gray-400 block">{{ $other->tanggal->isoFormat('D MMM Y') }}</span>
              <h4 class="text-xs font-bold text-gray-800 leading-snug group-hover:text-teal-700 transition-colors line-clamp-2 mt-0.5">{{ $other->judul }}</h4>
            </div>
          </a>
          @empty
          <p class="text-xs text-gray-400">Tidak ada berita lain.</p>
          @endforelse
        </div>
      </div>

    </div>
    
  </div>
</div>
@endsection
