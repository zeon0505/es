@extends('layouts.app')

@section('content')
<div class="space-y-10">

  {{-- Intro --}}
  <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-4">
    <div class="flex items-start gap-4">
      <div class="w-14 h-14 bg-teal-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg flex-shrink-0">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <div>
        <h2 class="font-bold text-gray-800 text-xl">Kurikulum S1 Ekonomi Syariah</h2>
        <p class="text-gray-500 text-sm mt-1 leading-relaxed">Kurikulum Ekonomi Syariah dirancang untuk menghasilkan lulusan yang kompeten dalam bidang pengajaran agama Islam, menguasai ilmu pedagogik, serta memiliki jiwa edupreneurship yang kuat. Beban studi diselesaikan dalam 8 semester (4 tahun).</p>
      </div>
    </div>
  </div>

  {{-- Semester Map --}}
  <div class="space-y-4">
    <h3 class="font-bold text-gray-800 text-lg">Distribusi Mata Kuliah Per Semester</h3>

    @php
    $semesters = [
      1 => ['Al-Qur\'an Hadits I', 'Akidah Akhlak', 'Bahasa Arab I', 'Bahasa Indonesia', 'Filsafat Ilmu', 'Pengantar Ilmu Pendidikan', 'Pancasila & Kewarganegaraan'],
      2 => ['Al-Qur\'an Hadits II', 'Fiqih Ibadah', 'Bahasa Arab II', 'Bahasa Inggris', 'Psikologi Umum', 'Sejarah Kebudayaan Islam', 'Ilmu Tafsir'],
      3 => ['Tafsir Tarbawi', 'Hadits Tarbawi', 'Psikologi Pendidikan', 'Kurikulum Ekonomi Syariah', 'Perencanaan Pembelajaran', 'Ilmu Kalam', 'Ilmu Tasawuf'],
      4 => ['Strategi Pembelajaran Ekonomi Syariah', 'Evaluasi Pembelajaran', 'Media Pembelajaran', 'Fiqih Munakahat', 'Ushul Fiqih', 'Metodologi Studi Islam'],
      5 => ['Micro Teaching', 'Bimbingan Konseling', 'Manajemen Pendidikan', 'Fiqih Muamalah', 'Edupreneurship I', 'Penelitian Pendidikan'],
      6 => ['PPL I', 'Kajian Kitab Kuning', 'Pendidikan Inklusi', 'Edupreneurship II', 'KKN', 'Kapita Selekta Ekonomi Syariah'],
      7 => ['PPL II / Magang', 'Skripsi / Tugas Akhir (Pra-Proposal)', 'Seminar Proposal'],
      8 => ['Skripsi', 'Ujian Komprehensif', 'Munaqasah'],
    ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @foreach($semesters as $sem => $matkul)
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-teal-700 px-5 py-3 flex items-center gap-3">
          <span class="text-white font-black text-lg">Semester {{ $sem }}</span>
          <span class="ml-auto text-[11px] text-teal-200 font-semibold bg-white/10 px-2.5 py-0.5 rounded-full">{{ count($matkul) }} MK</span>
        </div>
        <div class="px-5 py-4 space-y-1.5">
          @foreach($matkul as $mk)
          <div class="flex items-center gap-2.5 text-sm text-gray-700">
            <i class="fas fa-book-open text-teal-500 text-[11px] flex-shrink-0"></i>
            {{ $mk }}
          </div>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- Download CTA --}}
  <div class="bg-gray-100/70 border border-gray-200/50 rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex items-center gap-4">
      <div class="w-14 h-14 bg-red-500 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-red-500/10">
        <i class="fas fa-file-pdf"></i>
      </div>
      <div>
        <h4 class="font-bold text-gray-800 text-lg">Dokumen Lengkap Kurikulum Ekonomi Syariah</h4>
        <p class="text-sm text-gray-500">Unduh dokumen resmi struktur kurikulum dalam format PDF.</p>
      </div>
    </div>
    <a href="https://drive.google.com/file/d/1Xh-8eYSYaGyTPKhzxoENRqqnvY7ydzk5/view?usp=sharing" target="_blank" class="w-full md:w-auto bg-teal-700 hover:bg-teal-800 text-white font-bold px-8 py-3.5 rounded-xl text-sm shadow transition-colors flex items-center justify-center gap-2">
      <i class="fas fa-cloud-download-alt"></i> Download PDF Kurikulum
    </a>
  </div>

</div>
@endsection
