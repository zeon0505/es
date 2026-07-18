@extends('layouts.admin')
@section('title', 'Dosen Ekonomi Syariah')
@section('breadcrumb', 'Kelola data dosen pengajar Ekonomi Syariah STAIMAS')
@section('header-action')
  <a href="{{ route('admin.dosens.create') }}" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold px-4 py-2 rounded-xl transition-colors shadow">
    <i class="fas fa-user-plus"></i> Tambah Dosen
  </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[800px]">
      <thead class="bg-gray-50 border-b border-gray-100">
      <tr>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Foto</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Nama</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Jabatan</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Urutan</th>
        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
        <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-50">
      @forelse($dosens as $dosen)
      <tr class="hover:bg-gray-50/50">
        <td class="px-6 py-3">
          <div class="w-10 h-10 rounded-xl overflow-hidden bg-teal-100 flex items-center justify-center">
            @if($dosen->foto)
            <img src="{{ str_starts_with($dosen->foto, 'http') ? $dosen->foto : asset('storage/' . $dosen->foto) }}"
                 alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
            @else
            <i class="fas fa-user text-teal-500 text-sm"></i>
            @endif
          </div>
        </td>
        <td class="px-6 py-3 font-semibold text-gray-800">{{ $dosen->nama }}</td>
        <td class="px-6 py-3 text-gray-500">{{ $dosen->jabatan }}</td>
        <td class="px-6 py-3 text-gray-500">{{ $dosen->urutan }}</td>
        <td class="px-6 py-3">
          <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $dosen->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
            {{ $dosen->aktif ? 'Aktif' : 'Nonaktif' }}
          </span>
        </td>
        <td class="px-6 py-3 text-right">
          <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.dosens.edit', $dosen) }}" class="text-xs font-semibold text-teal-700 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg transition-all">
              <i class="fas fa-pen text-[10px]"></i> Edit
            </a>
            <form action="{{ route('admin.dosens.destroy', $dosen) }}" method="POST">
              @csrf @method('DELETE')
              <button type="button" onclick="confirmDelete(this.closest('form'), '{{ addslashes($dosen->nama) }}')" class="text-xs font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-all">
                <i class="fas fa-trash text-[10px]"></i> Hapus
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">
        <i class="fas fa-user-tie text-3xl mb-2 block opacity-30"></i>
        Belum ada dosen. <a href="{{ route('admin.dosens.create') }}" class="text-teal-700 font-semibold">Tambah sekarang</a>
      </td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection