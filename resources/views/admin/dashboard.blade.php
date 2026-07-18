@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', 'Selamat datang di Admin Panel Ekonomi Syariah STAIMAS Wonogiri')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  @foreach([
    ['label'=>'Total Berita','value'=>$totalBerita,'icon'=>'fas fa-newspaper','color'=>'bg-blue-500','bg'=>'bg-blue-50','text'=>'text-blue-600','route'=>'admin.beritas.index'],
    ['label'=>'Total Dosen','value'=>$totalDosen,'icon'=>'fas fa-user-tie','color'=>'bg-teal-600','bg'=>'bg-teal-50','text'=>'text-teal-600','route'=>'admin.dosens.index'],
    ['label'=>'Hero Slider','value'=>$totalSlide,'icon'=>'fas fa-images','color'=>'bg-purple-500','bg'=>'bg-purple-50','text'=>'text-purple-600','route'=>'admin.slides.index'],
    ['label'=>'Poster','value'=>$totalPoster,'icon'=>'fas fa-flag','color'=>'bg-yellow-500','bg'=>'bg-yellow-50','text'=>'text-yellow-600','route'=>'admin.posters.index'],
  ] as $stat)
  <a href="{{ route($stat['route']) }}" class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
    <div class="w-11 h-11 {{ $stat['bg'] }} {{ $stat['text'] }} rounded-xl flex items-center justify-center text-lg flex-shrink-0">
      <i class="{{ $stat['icon'] }}"></i>
    </div>
    <div>
      <p class="text-2xl font-black text-gray-800">{{ $stat['value'] }}</p>
      <p class="text-xs text-gray-500 font-medium">{{ $stat['label'] }}</p>
    </div>
  </a>
  @endforeach
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
  <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
      <h3 class="font-bold text-gray-800 text-sm">Berita Terbaru</h3>
      <a href="{{ route('admin.beritas.create') }}" class="text-xs font-bold text-teal-700 hover:underline flex items-center gap-1">
        <i class="fas fa-plus"></i> Tambah Berita
      </a>
    </div>
    <div class="divide-y divide-gray-50">
      @forelse($beritaTerbaru as $b)
      <div class="px-6 py-3 flex items-center justify-between gap-4">
        <div class="min-w-0">
          <p class="text-sm font-semibold text-gray-800 truncate">{{ $b->judul }}</p>
          <p class="text-[11px] text-gray-400 mt-0.5">
            {{ $b->tanggal->format('d M Y') }}
            @if($b->kategori) · <span class="text-teal-600">{{ $b->kategori->nama }}</span>@endif
          </p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
          <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $b->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
            {{ $b->aktif ? 'Aktif' : 'Draft' }}
          </span>
          <a href="{{ route('admin.beritas.edit', $b) }}" class="text-gray-400 hover:text-teal-600 text-sm"><i class="fas fa-pen"></i></a>
        </div>
      </div>
      @empty
      <div class="px-6 py-8 text-center text-sm text-gray-400">
        <i class="fas fa-newspaper text-2xl mb-2 block opacity-30"></i> Belum ada berita
      </div>
      @endforelse
    </div>
    <div class="px-6 py-3 bg-gray-50/50 border-t border-gray-100">
      <a href="{{ route('admin.beritas.index') }}" class="text-xs text-teal-700 font-bold hover:underline">Lihat semua berita →</a>
    </div>
  </div>

  <div class="space-y-4">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-3">
      <h3 class="font-bold text-gray-800 text-sm">Aksi Cepat</h3>
      <a href="{{ route('admin.beritas.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-all">
        <i class="fas fa-plus-circle text-blue-600"></i>
        <span class="text-sm font-semibold text-blue-700">Tambah Berita Baru</span>
      </a>
      <a href="{{ route('admin.dosens.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-teal-50 hover:bg-teal-100 transition-all">
        <i class="fas fa-user-plus text-teal-600"></i>
        <span class="text-sm font-semibold text-teal-700">Tambah Dosen</span>
      </a>
      <a href="{{ route('admin.slides.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-purple-50 hover:bg-purple-100 transition-all">
        <i class="fas fa-image text-purple-600"></i>
        <span class="text-sm font-semibold text-purple-700">Upload Slide Baru</span>
      </a>
      <a href="{{ route('admin.posters.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-yellow-50 hover:bg-yellow-100 transition-all">
        <i class="fas fa-flag text-yellow-600"></i>
        <span class="text-sm font-semibold text-yellow-700">Tambah Poster</span>
      </a>
    </div>

    <div class="bg-gradient-to-br from-teal-700 to-teal-900 rounded-2xl p-5 text-white space-y-2">
      <p class="text-xs font-bold text-teal-300 uppercase tracking-wider">Info Login Admin</p>
      <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
      <p class="text-xs text-teal-300">{{ auth()->user()->email }}</p>
      <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-2 text-xs text-yellow-300 hover:text-yellow-200 font-semibold">
        <i class="fas fa-external-link-alt"></i> Buka Website Ekonomi Syariah
      </a>
    </div>
  </div>
</div>
@endsection
