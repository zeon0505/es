@extends('layouts.admin')
@section('title', 'Kategori Berita')
@section('breadcrumb', 'Kelola kategori pengelompokan berita Ekonomi Syariah')
@section('header-action')
  <a href="{{ route('admin.kategoris.create') }}" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold px-4 py-2 rounded-xl transition-colors shadow">
    <i class="fas fa-plus"></i> Tambah Kategori
  </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[640px]">
      <thead class="bg-gray-50 border-b border-gray-100">
      <tr>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kategori</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Slug</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Berita</th>
        <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-50">
      @forelse($kategoris as $kategori)
      <tr class="hover:bg-gray-50/50">
        <td class="px-6 py-3 font-semibold text-gray-800">
          <span class="inline-flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-teal-500"></span>
            {{ $kategori->nama }}
          </span>
        </td>
        <td class="px-6 py-3">
          <code class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $kategori->slug }}</code>
        </td>
        <td class="px-6 py-3">
          <span class="inline-flex items-center gap-1.5 text-sm font-bold text-gray-700">
            <i class="fas fa-newspaper text-teal-400 text-xs"></i>
            {{ $kategori->beritas_count ?? 0 }} berita
          </span>
        </td>
        <td class="px-6 py-3 text-right">
          <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.kategoris.edit', $kategori) }}" class="text-xs font-semibold text-teal-700 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg transition-all">
              <i class="fas fa-pen text-[10px]"></i> Edit
            </a>
            <form action="{{ route('admin.kategoris.destroy', $kategori) }}" method="POST">
              @csrf @method('DELETE')
              <button type="button" onclick="confirmDelete(this.closest('form'), '{{ addslashes($kategori->nama) }}')" class="text-xs font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-all">
                <i class="fas fa-trash text-[10px]"></i> Hapus
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">
        <i class="fas fa-tags text-3xl mb-2 block opacity-30"></i>
        Belum ada kategori. <a href="{{ route('admin.kategoris.create') }}" class="text-teal-700 font-semibold">Tambah sekarang</a>
      </td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection