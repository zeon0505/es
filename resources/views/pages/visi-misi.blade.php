@extends('layouts.app')

@section('content')
<div class="space-y-10">

  {{-- Tab Navigation --}}
  <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 shadow-sm space-y-6">
    <div class="border-b border-gray-100">
      <div class="flex overflow-x-auto gap-4 sm:gap-8 pb-px no-scrollbar">
        <button onclick="switchTab('visi')" id="tab-visi" class="tab-btn pb-4 text-sm font-bold text-teal-700 border-b-2 border-teal-700 whitespace-nowrap focus:outline-none">Visi Keilmuan</button>
        <button onclick="switchTab('misi')" id="tab-misi" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-teal-700 border-b-2 border-transparent whitespace-nowrap focus:outline-none">Misi Keilmuan</button>
        <button onclick="switchTab('tujuan')" id="tab-tujuan" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-teal-700 border-b-2 border-transparent whitespace-nowrap focus:outline-none">Tujuan</button>
        <button onclick="switchTab('strategi')" id="tab-strategi" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-teal-700 border-b-2 border-transparent whitespace-nowrap focus:outline-none">Strategi</button>
      </div>
    </div>

    <div class="min-h-[250px]">
      {{-- VISI --}}
      <div id="content-visi" class="tab-content block space-y-4">
        <div class="bg-teal-50 border-l-4 border-teal-600 p-6 rounded-r-2xl">
          <h2 class="font-bold text-gray-800 text-xl mb-3">Visi Keilmuan Program Studi Ekonomi Syariah</h2>
          <p class="text-gray-700 text-base leading-relaxed italic">
            "Menjadi pusat kajian ilmu ekonomi syariah di bidang ekonomi pembangunan dan keuangan syariah serta entrepreneur bisnis yang berbasis prinsip pemberdayaan masyarakat, nilai-nilai keindonesiaan, dan religius kekaryaan."
          </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
          @foreach([['fas fa-coins','Keuangan Syariah','Mengkaji instrumen keuangan mikro & makro islam'],['fas fa-chart-line','Entrepreneur Bisnis','Membangun jiwa kewirausahaan islami yang tangguh'],['fas fa-users','Pemberdayaan','Fokus pada ekonomi keumatan berbasis keindonesiaan']] as $poin)
          <div class="p-5 bg-gray-50 rounded-2xl text-center space-y-2">
            <div class="w-11 h-11 bg-teal-100 text-teal-700 rounded-xl flex items-center justify-center mx-auto"><i class="{{ $poin[0] }}"></i></div>
            <h4 class="font-bold text-gray-800 text-sm">{{ $poin[1] }}</h4>
            <p class="text-xs text-gray-500">{{ $poin[2] }}</p>
          </div>
          @endforeach
        </div>
      </div>

      {{-- MISI --}}
      <div id="content-misi" class="tab-content hidden space-y-4">
        <h2 class="font-bold text-gray-800 text-xl">Misi Keilmuan Program Studi Ekonomi Syariah</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @foreach([
            ['fas fa-university','Menyelenggarakan pendidikan dan pengajaran ekonomi syariah yang memenuhi standarisasi pendidikan ekonomi syariah di Indonesia.'],
            ['fas fa-search-dollar','Menyelenggarakan penelitian dan pengembangan bidang ekonomi syariah berlandaskan nilai-nilai Islam.'],
            ['fas fa-hand-holding-heart','Melaksanakan pengabdian bidang ekonomi syariah di masyarakat.'],
            ['fas fa-handshake','Menyelenggarakan kerjasama dengan institusi lain dalam pengembangan keilmuan and praktik ekonomi syariah.']
          ] as $i => $misi)
          <div class="p-5 bg-gray-50 rounded-2xl flex gap-4 items-start">
            <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center flex-shrink-0"><i class="{{ $misi[0] }} text-sm"></i></div>
            <div>
              <span class="text-[10px] font-bold text-teal-600 uppercase tracking-wider">Misi {{ $i + 1 }}</span>
              <p class="text-gray-600 text-sm leading-relaxed mt-1">{{ $misi[1] }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- TUJUAN --}}
      <div id="content-tujuan" class="tab-content hidden space-y-4">
        <h2 class="font-bold text-gray-800 text-xl">Tujuan Program Studi Ekonomi Syariah</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @foreach([
            'Menghasilkan lulusan Ekonomi Syariah yang berintegritas tinggi serta kompeten di bidang analisis ekonomi pembangunan dan keuangan syariah.',
            'Menghasilkan kajian ilmiah dan hasil penelitian inovatif yang berkontribusi pada pengembangan praktik perbankan dan lembaga keuangan syariah.',
            'Mewujudkan program pemberdayaan ekonomi masyarakat berbasis prinsip-prinsip syariah secara berkelanjutan.',
            'Membangun jaringan kemitraan strategis dengan industri perbankan, koperasi syariah, serta lembaga bisnis untuk mempercepat serapan kerja lulusan.'
          ] as $i => $tujuan)
          <div class="p-5 bg-gray-50 rounded-2xl flex gap-3">
            <span class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 text-sm font-bold flex items-center justify-center flex-shrink-0">{{ $i + 1 }}</span>
            <p class="text-gray-600 text-sm leading-relaxed">{{ $tujuan }}</p>
          </div>
          @endforeach
        </div>
      </div>

      {{-- STRATEGI --}}
      <div id="content-strategi" class="tab-content hidden space-y-4">
        <h2 class="font-bold text-gray-800 text-xl">Strategi Program Studi Ekonomi Syariah</h2>
        <div class="space-y-3">
          @foreach([
            'Meningkatkan mutu kurikulum secara periodik selaras dengan perkembangan industri keuangan sosial islam dan fintech syariah.',
            'Mengakselerasi publikasi ilmiah dosen dan mahasiswa pada jurnal terakreditasi nasional maupun internasional.',
            'Melaksanakan pembimbingan bisnis dan inkubasi wirausaha bagi mahasiswa guna mencetak lulusan berjiwa entrepreneur.',
            'Mengoptimalkan pemanfaatan laboratorium mini bank syariah dan instrumen digital pendukung pembelajaran praktis.'
          ] as $i => $strategi)
          <div class="p-4 bg-gray-50 rounded-xl flex items-start gap-4">
            <div class="w-8 h-8 rounded-full bg-teal-600 text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">{{ $i + 1 }}</div>
            <p class="text-gray-700 text-sm leading-relaxed">{{ $strategi }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</div>

<script>
function switchTab(tabId) {
  document.querySelectorAll('.tab-content').forEach(c => { c.classList.add('hidden'); c.classList.remove('block'); });
  document.querySelectorAll('.tab-btn').forEach(b => { b.classList.remove('text-teal-700','border-teal-700'); b.classList.add('text-gray-400','border-transparent'); });
  const ac = document.getElementById('content-' + tabId);
  if (ac) { ac.classList.remove('hidden'); ac.classList.add('block'); }
  const ab = document.getElementById('tab-' + tabId);
  if (ab) { ab.classList.remove('text-gray-400','border-transparent'); ab.classList.add('text-teal-700','border-teal-700'); }
}
</script>
@endsection
