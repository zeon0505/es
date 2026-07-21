@extends('layouts.app')
@section('title', 'Akreditasi Ekonomi Syariah')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

  {{-- PDF Google Viewer (Tanpa Toolbar) --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-1 sm:p-2">
    <iframe
      src="https://docs.google.com/gview?url={{ urlencode(asset('assest/Sertifikat Akreditasi ES.pdf')) }}&embedded=true"
      class="w-full"
      style="height: 78vh; min-height: 550px; border: none;"
      title="Sertifikat Akreditasi ES">
    </iframe>
  </div>

  {{-- Tombol Aksi di Bawah --}}
  <div class="flex justify-center gap-3">
    <a href="{{ asset('assest/Sertifikat%20Akreditasi%20ES.pdf') }}" target="_blank"
       class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold px-6 py-3 rounded-xl transition-all shadow">
      <i class="fas fa-file-pdf"></i> Buka File PDF Asli
    </a>
    <a href="{{ asset('assest/Sertifikat%20Akreditasi%20ES.pdf') }}" download
       class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold px-6 py-3 rounded-xl transition-all">
      <i class="fas fa-download"></i> Unduh Sertifikat
    </a>
  </div>

</div>
@endsection
