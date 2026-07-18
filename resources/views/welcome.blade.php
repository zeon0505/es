@extends('layouts.app')

@section('content')
<div class="space-y-16">
  <!-- HERO CAROUSEL -->
  <section class="carousel-container min-h-[50vh] md:min-h-[70vh] bg-teal-900 rounded-3xl overflow-hidden relative -mt-6" id="beranda">
    <div class="carousel-track" id="carousel-track">
      @forelse($slides as $slide)
      @php
        $imgUrl = str_starts_with($slide->gambar, 'http') ? $slide->gambar : asset('storage/' . $slide->gambar);
      @endphp
      <div class="carousel-slide relative min-h-[50vh] md:min-h-[70vh] flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ $imgUrl }}')">
        <div class="absolute inset-0 bg-black/30 z-0"></div>
      </div>
      @empty
      <div class="carousel-slide relative min-h-[50vh] md:min-h-[70vh] flex items-center justify-center bg-teal-800">
        <p class="text-teal-300 text-sm">Belum ada slide. <a href="{{ route('admin.slides.create') }}" class="underline">Tambah di admin</a>.</p>
      </div>
      @endforelse
    </div>
    <button class="absolute top-1/2 left-4 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center focus:outline-none transition-all" id="carousel-prev"><i class="fas fa-chevron-left"></i></button>
    <button class="absolute top-1/2 right-4 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center focus:outline-none transition-all" id="carousel-next"><i class="fas fa-chevron-right"></i></button>
  </section>

  <!-- Introduction Box -->
  <div class="bg-gradient-to-br from-teal-800 to-teal-900 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(201,168,76,0.15),transparent_60%)]"></div>
    <div class="relative z-10 max-w-3xl space-y-4">
      <span class="inline-block bg-yellow-500/20 text-yellow-300 border border-yellow-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">S1 - Terakreditasi B</span>
      <h2 class="text-3xl sm:text-4xl font-black leading-tight">Ekonomi Syariah STAIMAS: Cetak Ahli Ekonomi Pembangunan & Keuangan Islam</h2>
      <p class="text-teal-100 text-sm sm:text-base leading-relaxed">
        Ingin menjadi pakar keuangan syariah atau wirausahawan berlandaskan nilai-nilai Islam? Prodi Ekonomi Syariah STAIMAS Wonogiri hadir untuk mencetak lulusan unggul yang siap berkontribusi pada pengembangan ekonomi keumatan dan bisnis islami. Yuk, gabung bersama kami!
      </p>
      <div class="pt-4 flex flex-wrap gap-4">
        <a href="https://staimaswonogiri.ecampuz.com/eadmisi/" target="_blank" class="bg-yellow-500 hover:bg-yellow-600 text-gray-950 font-bold px-6 py-3 rounded-xl text-sm transition-all shadow-md shadow-yellow-500/20 flex items-center gap-2">
          <i class="fas fa-user-plus"></i> Daftar PMB Ekosy 2025
        </a>
        <a href="#kurikulum" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold px-6 py-3 rounded-xl text-sm transition-all flex items-center gap-2">
          <i class="fas fa-file-download"></i> Kurikulum Ekosy
        </a>
      </div>
    </div>
  </div>

  <!-- Visi, Misi, Tujuan, Strategi Tabs -->
  <div id="visi-misi" class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 shadow-sm space-y-6">
    <div class="border-b border-gray-100">
      <div class="flex overflow-x-auto gap-4 sm:gap-8 pb-px no-scrollbar">
        <button onclick="switchTab('visi')" id="tab-visi" class="tab-btn pb-4 text-sm font-bold text-teal-700 border-b-2 border-teal-700 transition-all whitespace-nowrap focus:outline-none">
          Visi Keilmuan
        </button>
        <button onclick="switchTab('misi')" id="tab-misi" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-teal-700 border-b-2 border-transparent transition-all whitespace-nowrap focus:outline-none">
          Misi Keilmuan
        </button>
        <button onclick="switchTab('tujuan')" id="tab-tujuan" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-teal-700 border-b-2 border-transparent transition-all whitespace-nowrap focus:outline-none">
          Tujuan
        </button>
        <button onclick="switchTab('strategi')" id="tab-strategi" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-teal-700 border-b-2 border-transparent transition-all whitespace-nowrap focus:outline-none">
          Strategi
        </button>
      </div>
    </div>

    <!-- Tab Contents -->
    <div class="min-h-[200px]">
      <!-- VISI -->
      <div id="content-visi" class="tab-content block space-y-4 animate-fadeIn">
        <div class="bg-teal-50/50 border-l-4 border-teal-600 p-6 rounded-r-2xl">
          <h4 class="font-bold text-gray-800 text-lg mb-2">Visi Keilmuan Program Studi Ekonomi Syariah</h4>
          <p class="text-gray-700 text-sm leading-relaxed italic">
            "Menjadi pusat kajian ilmu ekonomi syariah di bidang ekonomi pembangunan dan keuangan syariah serta entrepreneur bisnis yang berbasis prinsip pemberdayaan masyarakat, nilai-nilai keindonesiaan, dan religius kekaryaan."
          </p>
        </div>
      </div>

      <!-- MISI -->
      <div id="content-misi" class="tab-content hidden space-y-4 animate-fadeIn">
        <h4 class="font-bold text-gray-800 text-lg">Misi Keilmuan Program Studi Ekonomi Syariah</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @foreach([
            'Menyelenggarakan pendidikan dan pengajaran ekonomi syariah yang memenuhi standarisasi pendidikan ekonomi syariah di Indonesia.',
            'Menyelenggarakan penelitian dan pengembangan bidang ekonomi syariah berlandaskan nilai-nilai Islam.',
            'Melaksanakan pengabdian bidang ekonomi syariah di masyarakat.',
            'Menyelenggarakan kerjasama dengan institusi lain dalam pengembangan keilmuan dan praktik ekonomi syariah.'
          ] as $i => $misi)
          <div class="p-5 bg-gray-50 rounded-2xl flex gap-3">
            <span class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 text-sm font-bold flex items-center justify-center flex-shrink-0">{{ $i + 1 }}</span>
            <p class="text-gray-600 text-sm leading-relaxed">{{ $misi }}</p>
          </div>
          @endforeach
        </div>
      </div>

      <!-- TUJUAN -->
      <div id="content-tujuan" class="tab-content hidden space-y-4 animate-fadeIn">
        <h4 class="font-bold text-gray-800 text-lg">Tujuan Program Studi Ekonomi Syariah</h4>
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

      <!-- STRATEGI -->
      <div id="content-strategi" class="tab-content hidden space-y-4 animate-fadeIn">
        <h4 class="font-bold text-gray-800 text-lg">Strategi Program Studi Ekonomi Syariah</h4>
        <div class="space-y-3">
          @foreach([
            'Meningkatkan mutu kurikulum secara periodik selaras dengan perkembangan industri keuangan sosial islam dan fintech syariah.',
            'Mengakselerasi publikasi ilmiah dosen dan mahasiswa pada jurnal terakreditasi nasional maupun internasional.',
            'Melaksanakan pembimbingan bisnis dan inkubasi wirausaha bagi mahasiswa guna mencetak lulusan berjiwa entrepreneur.',
            'Mengoptimalkan pemanfaatan laboratorium mini bank syariah dan instrumen digital pendukung pembelajaran praktis.'
          ] as $i => $strategi)
          <div class="p-4 bg-gray-50 rounded-xl flex items-center gap-4">
            <i class="fas fa-check-circle text-teal-600 flex-shrink-0 text-lg"></i>
            <p class="text-gray-700 text-sm leading-relaxed">{{ $strategi }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- BERITA & PENGUMUMAN -->
  <div class="space-y-6">
    <div class="flex justify-between items-end">
      <div class="space-y-2">
        <h3 class="text-2xl font-bold text-gray-800">Berita & Pengumuman</h3>
        <p class="text-sm text-gray-500">Kabar terbaru, pengumuman, dan artikel seputar Ekonomi Syariah STAIMAS.</p>
      </div>
      <a href="{{ route('pages.berita') }}" class="text-sm font-semibold text-teal-700 hover:text-teal-850 flex items-center gap-1">Lihat Semua Berita <i class="fas fa-arrow-right text-[10px]"></i></a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @forelse($beritas as $b)
      <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col">
        <div class="aspect-video w-full bg-teal-800 flex items-center justify-center relative overflow-hidden">
          @if($b->gambar)
          <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->judul }}" class="w-full h-full object-cover">
          @else
          <div class="absolute inset-0 bg-gradient-to-br from-teal-700 to-teal-900"></div>
          <span class="relative z-10 px-4 text-center text-sm font-semibold text-teal-200">{{ $b->judul }}</span>
          @endif
        </div>
        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              @if($b->kategori)<span class="text-[11px] font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-full">{{ $b->kategori->nama }}</span>@endif
              <span class="text-xs text-gray-400">{{ $b->tanggal->isoFormat('D MMM Y') }}</span>
            </div>
            <h4 class="font-bold text-gray-800 text-base leading-snug hover:text-teal-700 transition-colors">
              <a href="{{ route('pages.berita.show', $b->slug) }}">{{ $b->judul }}</a>
            </h4>
            <p class="text-xs text-gray-500 leading-relaxed">{{ Str::limit(strip_tags($b->konten), 90) }}</p>
          </div>
          <a href="{{ route('pages.berita.show', $b->slug) }}" class="text-xs font-bold text-teal-700 hover:underline flex items-center gap-1">Baca Selengkapnya <i class="fas fa-arrow-right text-[10px]"></i></a>
        </div>
      </div>
      @empty
      <div class="col-span-3 py-10 text-center text-gray-400 text-sm">Belum ada berita. Tambahkan melalui <a href="{{ route('admin.beritas.create') }}" class="text-teal-700 underline">admin panel</a>.</div>
      @endforelse
    </div>
  </div>

  <!-- Dosen Pengajar -->
  <div id="dosen" class="space-y-6">
    <div class="text-center max-w-xl mx-auto space-y-2">
      <h3 class="text-2xl font-bold text-gray-800">Dosen Pengajar Ekonomi Syariah</h3>
      <p class="text-sm text-gray-500">Profil para dosen profesional yang siap membimbing dan menginspirasi langkah akademismu di bidang Ekonomi Syariah.</p>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($dosens as $d)
      <a href="{{ route('pages.dosen.show', $d) }}" class="block bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow text-center p-4 group">
        <div class="aspect-[3/4] w-full rounded-xl overflow-hidden mb-3 bg-gray-50">
          @if($d->foto)
          <img src="{{ str_starts_with($d->foto, 'http') ? $d->foto : asset('storage/' . $d->foto) }}" alt="{{ $d->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
          @else
          <div class="w-full h-full bg-teal-100 flex items-center justify-center"><i class="fas fa-user text-teal-400 text-2xl"></i></div>
          @endif
        </div>
        <h4 class="font-bold text-gray-800 text-sm leading-snug group-hover:text-teal-700 transition-colors">{{ $d->nama }}</h4>
        <p class="text-xs text-gray-400 mt-1">{{ $d->jabatan }}</p>
      </a>
      @empty
      <div class="col-span-4 py-8 text-center text-gray-400 text-sm">Belum ada data dosen.</div>
      @endforelse
    </div>

    <div class="text-center pt-4">
      <a href="{{ route('pages.dosen') }}" class="inline-block bg-teal-100 hover:bg-teal-200 text-teal-800 font-bold px-8 py-3 rounded-xl text-sm transition-all shadow-sm">
        Lihat Selengkapnya <i class="fas fa-arrow-right text-xs ml-1"></i>
      </a>
    </div>
  </div>

  <!-- Kurikulum / Download Section -->
  <div id="kurikulum" class="bg-gray-100/70 border border-gray-200/50 rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex items-center gap-4">
      <div class="w-14 h-14 bg-teal-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-teal-600/10">
        <i class="fas fa-file-pdf"></i>
      </div>
      <div>
        <h4 class="font-bold text-gray-800 text-lg">Struktur Kurikulum Ekosy</h4>
        <p class="text-sm text-gray-500">Download struktur kurikulum mata kuliah program studi Ekonomi Syariah.</p>
      </div>
    </div>
    <a href="https://drive.google.com/file/d/1Xh-8eYSYaGyTPKhzxoENRqqnvY7ydzk5/view?usp=sharing" target="_blank" class="w-full md:w-auto bg-teal-700 hover:bg-teal-800 text-white font-bold px-8 py-3.5 rounded-xl text-sm shadow transition-colors flex items-center justify-center gap-2">
      <i class="fas fa-cloud-download-alt"></i> Download PDF
    </a>
  </div>

  <!-- Contact & Map Section -->
  <div id="kontak" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start pt-6">
    <div class="lg:col-span-7 bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
      <h3 class="font-bold text-gray-900 text-lg mb-6">Ajukan Pertanyaan</h3>
      <form class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <input type="text" placeholder="Nama Lengkap" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-sm focus:outline-none focus:border-teal-brand" required />
          <input type="tel" placeholder="Nomor Telepon/WA" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-sm focus:outline-none focus:border-teal-brand" />
        </div>
        <input type="email" placeholder="Alamat Email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-sm focus:outline-none focus:border-teal-brand" required />
        <textarea rows="4" placeholder="Tulis pesan Anda..." class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-sm focus:outline-none focus:border-teal-brand" required></textarea>
        <button type="submit" class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold py-3.5 rounded-lg shadow transition-colors">Kirim Pesan</button>
      </form>
    </div>

    <div class="lg:col-span-5 space-y-4">
      <div class="bg-white rounded-2xl border border-gray-100 p-5 flex gap-4 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-brand text-lg shrink-0"><i class="fas fa-map-marker-alt"></i></div>
        <div>
          <h4 class="font-bold text-gray-900 text-sm">Alamat Kampus</h4>
          <p class="text-xs text-gray-500 mt-1">Jl. Cempaka 6, Wonoboyo, Kec. Wonogiri, Wonogiri, Jawa Tengah 57615</p>
        </div>
      </div>
      <div class="bg-white rounded-2xl border border-gray-100 p-5 flex gap-4 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-brand text-lg shrink-0"><i class="fab fa-whatsapp"></i></div>
        <div>
          <h4 class="font-bold text-gray-900 text-sm">WhatsApp</h4>
          <p class="text-xs text-gray-500 mt-1">082223204552</p>
        </div>
      </div>

      <div class="kontak-map rounded-2xl overflow-hidden shadow-sm border border-gray-100">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2044.960527882958!2d110.93878935266353!3d-7.813874308778577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a2e51f116d5bb%3A0x26cbc235ed5a2edc!2sSTAIMAS%20(Sekolah%20Tinggi%20Agama%20Islam%20Mulia%20Astuti)!5e1!3m2!1sid!2sid!4v1741595178278!5m2!1sid!2sid"
          width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi Kampus Ekonomi Syariah STAIMAS"></iframe>
      </div>
    </div>
  </div>
</div>

<script>
  function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(content => {
      content.classList.add('hidden');
      content.classList.remove('block');
    });

    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.classList.remove('text-teal-700', 'border-teal-700');
      btn.classList.add('text-gray-400', 'border-transparent');
    });

    const activeContent = document.getElementById('content-' + tabId);
    if (activeContent) {
      activeContent.classList.remove('hidden');
      activeContent.classList.add('block');
    }

    const activeBtn = document.getElementById('tab-' + tabId);
    if (activeBtn) {
      activeBtn.classList.remove('text-gray-400', 'border-transparent');
      activeBtn.classList.add('text-teal-700', 'border-teal-700');
    }
  }
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fadeIn {
    animation: fadeIn 0.3s ease-out forwards;
  }
  
  /* Carousel Styles */
  .carousel-track {
    display: flex;
    transition: transform 0.5s ease-in-out;
    height: 100%;
    width: 100%;
  }
  .carousel-slide {
    flex: 0 0 100%;
    width: 100%;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('carousel-track');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');
    
    if (track && prevBtn && nextBtn) {
      const slidesCount = track.querySelectorAll('.carousel-slide').length;
      if (slidesCount > 1) {
        let currentSlide = 0;
        
        function updateCarousel() {
          track.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
        
        nextBtn.addEventListener('click', () => {
          currentSlide = (currentSlide + 1) % slidesCount;
          updateCarousel();
        });
        
        prevBtn.addEventListener('click', () => {
          currentSlide = (currentSlide - 1 + slidesCount) % slidesCount;
          updateCarousel();
        });
        
        // Auto-slide
        setInterval(() => {
          currentSlide = (currentSlide + 1) % slidesCount;
          updateCarousel();
        }, 5000);
      } else {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
      }
    }
  });
</script>
@endsection