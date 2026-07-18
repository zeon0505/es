@extends('layouts.admin')
@section('title', 'Hero Slider')
@section('breadcrumb', 'Kelola gambar hero carousel di halaman beranda')
@section('header-action')
  <a href="{{ route('admin.slides.create') }}" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold px-4 py-2 rounded-xl transition-colors shadow">
    <i class="fas fa-plus"></i> Tambah Slide
  </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[640px]">
      <thead class="bg-gray-50 border-b border-gray-100">
      <tr>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Preview</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Urutan</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
        <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-50">
      @forelse($slides as $slide)
      <tr class="hover:bg-gray-50/50">
        <td class="px-6 py-3">
          <div class="w-24 h-14 rounded-lg overflow-hidden bg-gray-100">
            <img src="{{ str_starts_with($slide->gambar, 'http') ? $slide->gambar : asset('storage/' . $slide->gambar) }}"
                 alt="{{ $slide->judul }}" class="w-full h-full object-cover">
          </div>
        </td>
        <td class="px-6 py-3 font-medium text-gray-800">{{ $slide->judul ?? '(tanpa judul)' }}</td>
        <td class="px-6 py-3 text-gray-500">{{ $slide->urutan }}</td>
        <td class="px-6 py-3">
          <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $slide->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
            {{ $slide->aktif ? 'Aktif' : 'Nonaktif' }}
          </span>
        </td>
        <td class="px-6 py-3 text-right">
          <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.slides.edit', $slide) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-teal-700 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg transition-all">
              <i class="fas fa-pen text-[10px]"></i> Edit
            </a>
            <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST">
              @csrf @method('DELETE')
              <button type="button" onclick="confirmDelete(this.closest('form'), '{{ addslashes($slide->judul ?? 'Slide') }}')" class="inline-flex items-center gap-1 text-xs font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-all">
                <i class="fas fa-trash text-[10px]"></i> Hapus
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">
        <i class="fas fa-images text-3xl mb-2 block opacity-30"></i>
        Belum ada slide. <a href="{{ route('admin.slides.create') }}" class="text-teal-700 font-semibold">Tambah sekarang</a>
      </td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection