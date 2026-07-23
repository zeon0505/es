<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Ekonomi Syariah STAIMAS Wonogiri' }} – Program Studi S1</title>
  <meta name="description" content="{{ $description ?? 'Program Studi Ekonomi Syariah (ES) S1 STAIMAS Wonogiri – Mencetak Ahli Ekonomi Islam yang Kompeten, Unggul, dan Berjiwa Wirausaha.' }}" />
  <link rel="icon" type="image/png" href="{{ asset('assest/LOGO STAIMAS AI.png') }}" />
  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .topbar-hidden { transform: translateY(-100%); margin-bottom: -40px; }
    .navbar-scrolled {
      background-color: rgba(255,255,255,0.95) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
      border-bottom: 1px solid rgba(229,231,235,0.8);
    }

    /* ── PAGE LOAD ANIMATION ── */
    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInLeft {
      from { opacity: 0; transform: translateX(-30px); }
      to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
      from { opacity: 0; transform: translateX(30px); }
      to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes scaleIn {
      from { opacity: 0; transform: scale(0.92); }
      to   { opacity: 1; transform: scale(1); }
    }
    @keyframes shimmer {
      0%   { background-position: -200% center; }
      100% { background-position:  200% center; }
    }
    @keyframes pulse-soft {
      0%, 100% { opacity: 1; }
      50%       { opacity: .6; }
    }
    @keyframes slideInFromRight {
      from { opacity: 0; transform: translate3d(20px, 0, 0); }
      to   { opacity: 1; transform: translate3d(0, 0, 0); }
    }
    @keyframes slideInFromLeft {
      from { opacity: 0; transform: translate3d(-20px, 0, 0); }
      to   { opacity: 1; transform: translate3d(0, 0, 0); }
    }

    /* Set class entrance untuk memicu transisi selembut sutra */
    .slide-from-right {
      animation: slideInFromRight 0.32s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
    }
    .slide-from-left {
      animation: slideInFromLeft 0.32s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
    }

    body {
      overflow-x: hidden;
      background-color: #f3f4f6; /* Pastikan background body solid abu-abu, bukan putih blink */
    }
    #page-wrapper {
      will-change: transform, opacity;
      transform: translate3d(0, 0, 0);
    }


    /* Navbar slide down */
    #navbar { animation: fadeInDown .4s ease .05s both; }

    /* Hero breadcrumb + heading */
    .page-hero-title { animation: fadeInUp .5s ease .1s both; }
    .page-hero-sub   { animation: fadeInUp .5s ease .2s both; }

    /* ── SCROLL REVEAL ── */
    .reveal {
      opacity: 0;
      transform: translateY(28px);
      transition: opacity .55s ease, transform .55s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .reveal-left  { opacity: 0; transform: translateX(-28px); transition: opacity .55s ease, transform .55s ease; }
    .reveal-right { opacity: 0; transform: translateX(28px);  transition: opacity .55s ease, transform .55s ease; }
    .reveal-left.visible, .reveal-right.visible { opacity: 1; transform: translate(0); }
    .reveal-scale { opacity: 0; transform: scale(.93); transition: opacity .5s ease, transform .5s ease; }
    .reveal-scale.visible { opacity: 1; transform: scale(1); }

    /* Stagger delay helpers */
    .delay-100 { transition-delay: .1s !important; }
    .delay-200 { transition-delay: .2s !important; }
    .delay-300 { transition-delay: .3s !important; }
    .delay-400 { transition-delay: .4s !important; }
    .delay-500 { transition-delay: .5s !important; }

    /* ── CARD HOVER LIFT ── */
    .card-hover {
      transition: transform .25s ease, box-shadow .25s ease;
    }
    .card-hover:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px -8px rgba(0,0,0,.12);
    }

    /* ── LOGO FLOAT ── */
    #navbar .logo-icon { animation: float 4s ease-in-out infinite; }

    /* ── NAV LINK UNDERLINE ── */
    nav a.nav-link {
      position: relative;
      padding-bottom: 2px;
    }
    nav a.nav-link::after {
      content: '';
      position: absolute;
      bottom: -2px; left: 0;
      width: 0; height: 2px;
      background: #0d7c7d;
      border-radius: 9999px;
      transition: width .25s ease;
    }
    nav a.nav-link:hover::after,
    nav a.nav-link.active::after { width: 100%; }


  </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

  <!-- TOP BAR -->
  <div class="bg-[#074e50] text-gray-200 text-xs py-2 px-4 z-50 relative transition-all duration-300" id="topbar">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
      <div class="flex items-center gap-4">
        <a href="tel:082223204552" class="hover:text-yellow-400 transition-colors"><i class="fas fa-phone mr-1.5 text-yellow-400"></i> 082223204552</a>
        <a href="mailto:staimaswonogiri@gmail.com" class="hover:text-yellow-400 transition-colors"><i class="fas fa-envelope mr-1.5 text-yellow-400"></i> staimaswonogiri@gmail.com</a>
      </div>
      <div class="flex items-center gap-4">
        <a href="https://staimaswonogiri.ecampuz.com/eadmisi/" target="_blank" class="bg-yellow-500 text-gray-900 px-3 py-1 rounded font-semibold hover:bg-yellow-600 transition-colors"><i class="fas fa-user-plus mr-1"></i> PMB 2025</a>
        <div class="flex items-center gap-2.5 ml-2 border-l border-teal-700 pl-3">
          <a href="https://www.facebook.com/people/staimaswonogiri/100068071263429/" target="_blank" class="hover:text-yellow-400"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/staimaswonogiri/" target="_blank" class="hover:text-yellow-400"><i class="fab fa-instagram"></i></a>
          <a href="https://www.youtube.com/@STAIMASWONOGIRI/featured" target="_blank" class="hover:text-yellow-400"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>
  </div>

  <!-- NAVBAR -->
  <header class="sticky top-0 bg-white border-b border-gray-100 z-40 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <a href="{{ route('home') }}" class="flex items-center gap-3 group">
        <div class="logo-icon w-12 h-12 bg-white rounded-full flex items-center justify-center border-2 border-yellow-500 shadow-md overflow-hidden">
          <img src="{{ asset('assest/ES.jpeg') }}" alt="ES Logo" class="w-full h-full object-contain p-0.5">
        </div>
        <div>
          <span class="block text-lg font-extrabold text-teal-700 tracking-tight leading-none">EKONOMI SYARIAH</span>
          <span class="text-xs font-semibold text-yellow-500 tracking-widest uppercase">STAIMAS Wonogiri</span>
        </div>
      </a>
 
      <nav class="hidden lg:block">
        <ul class="flex items-center gap-8 text-[14px] font-medium text-gray-600">
          <li><a href="{{ route('home') }}" class="nav-link hover:text-teal-700 transition-colors py-2 {{ request()->routeIs('home') ? 'font-bold text-teal-700 active' : '' }}">BERANDA</a></li>
          <li><a href="{{ route('pages.visi-misi') }}" class="nav-link hover:text-teal-700 transition-colors py-2 {{ request()->routeIs('pages.visi-misi') ? 'font-bold text-teal-700 active' : '' }}">VISI & MISI</a></li>
          <li><a href="{{ route('pages.dosen') }}" class="nav-link hover:text-teal-700 transition-colors py-2 {{ request()->routeIs('pages.dosen') ? 'font-bold text-teal-700 active' : '' }}">DOSEN</a></li>
          <li><a href="{{ route('pages.kurikulum') }}" class="nav-link hover:text-teal-700 transition-colors py-2 {{ request()->routeIs('pages.kurikulum') ? 'font-bold text-teal-700 active' : '' }}">KURIKULUM</a></li>
          <li><a href="{{ route('pages.berita') }}" class="nav-link hover:text-teal-700 transition-colors py-2 {{ request()->routeIs('pages.berita*') ? 'font-bold text-teal-700 active' : '' }}">BERITA ES</a></li>
          <li><a href="{{ route('pages.akreditasi') }}" class="nav-link hover:text-teal-700 transition-colors py-2 {{ request()->routeIs('pages.akreditasi') ? 'font-bold text-teal-700 active' : '' }}">AKREDITASI</a></li>
        </ul>
      </nav>
 
      <div class="flex items-center gap-3">
        <a href="https://staimaswonogiri.ecampuz.com/eadmisi/" target="_blank" class="hidden lg:inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors shadow">
          <i class="fas fa-graduation-cap"></i> PMB 2025
        </a>
        <button class="lg:hidden text-gray-600 hover:text-teal-700 text-2xl p-1" id="nav-toggle">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </div>
 
    <!-- Mobile Dropdown -->
    <div class="mobile-dropdown hidden absolute top-full left-0 w-full lg:hidden border-t border-gray-100 bg-white shadow-lg" id="mobile-menu">
      <ul class="flex flex-col px-4 py-2">
        <li><a href="{{ route('home') }}" class="flex items-center gap-3 py-3 border-b border-gray-100 text-sm font-semibold text-gray-700 hover:text-teal-700"><i class="fas fa-home w-4 text-teal-600"></i> Beranda</a></li>
        <li><a href="{{ route('pages.visi-misi') }}" class="flex items-center gap-3 py-3 border-b border-gray-100 text-sm font-semibold text-gray-700 hover:text-teal-700"><i class="fas fa-eye w-4 text-teal-600"></i> Visi & Misi</a></li>
        <li><a href="{{ route('pages.dosen') }}" class="flex items-center gap-3 py-3 border-b border-gray-100 text-sm font-semibold text-gray-700 hover:text-teal-700"><i class="fas fa-users w-4 text-teal-600"></i> Dosen</a></li>
        <li><a href="{{ route('pages.kurikulum') }}" class="flex items-center gap-3 py-3 border-b border-gray-100 text-sm font-semibold text-gray-700 hover:text-teal-700"><i class="fas fa-book w-4 text-teal-600"></i> Kurikulum</a></li>
        <li><a href="{{ route('pages.berita') }}" class="flex items-center gap-3 py-3 border-b border-gray-100 text-sm font-semibold text-gray-700 hover:text-teal-700"><i class="fas fa-newspaper w-4 text-teal-600"></i> Berita ES</a></li>
        <li><a href="{{ route('pages.akreditasi') }}" class="flex items-center gap-3 py-3 border-b border-gray-100 text-sm font-semibold text-gray-700 hover:text-teal-700"><i class="fas fa-certificate w-4 text-teal-600"></i> Akreditasi</a></li>
        <li class="py-4">
          <a href="https://staimaswonogiri.ecampuz.com/eadmisi/" target="_blank" class="flex justify-center items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white py-3 rounded-xl font-bold text-sm shadow transition-colors">
            <i class="fas fa-graduation-cap"></i> Daftar PMB 2025
          </a>
        </li>
      </ul>
    </div>
  </header>

  <script>
    document.getElementById('nav-toggle')?.addEventListener('click', function() {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    });
  </script>

  <!-- WRAPPER UNTUK TRANSISI -->
  <div id="page-wrapper">
    <!-- PAGE HERO -->
    @if(isset($title) && !request()->routeIs('home'))
    <section class="bg-gradient-to-br from-teal-800 to-teal-600 text-white py-12 px-4 overflow-hidden relative">
      <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 80% 50%, rgba(201,168,76,.6) 0%, transparent 60%);"></div>
      <div class="max-w-7xl mx-auto relative">
        <div class="page-hero-title flex items-center gap-2 text-sm text-teal-200 mb-3">
          <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
          <span>/</span>
          <span class="text-white font-medium">{{ $title }}</span>
        </div>
        <h1 class="page-hero-title text-3xl sm:text-4xl font-extrabold">{{ $title }}</h1>
        @if(isset($subtitle))<p class="page-hero-sub text-teal-100 mt-2 text-base">{{ $subtitle }}</p>@endif
      </div>
    </section>
    @endif

    <!-- KONTEN UTAMA -->
    <main class="max-w-7xl mx-auto px-4 py-12">
      @yield('content')
    </main>
  </div>

  <!-- FOOTER -->
  <footer class="bg-teal-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-xs">
      <div class="space-y-3">
        <h3 class="font-extrabold text-white text-sm">Prodi Ekonomi Syariah STAIMAS</h3>
        <p class="text-gray-400 leading-relaxed">Mendidik sarjana Ekonomi Syariah yang kompeten, profesional, unggul, dan berjiwa entrepreneurship islami.</p>
      </div>
      <div class="space-y-3">
        <h4 class="font-extrabold text-white text-xs uppercase tracking-wider">Akses Cepat</h4>
        <ul class="space-y-2">
          <li><a href="{{ route('home') }}" class="hover:text-yellow-400">Beranda</a></li>
          <li><a href="{{ route('pages.visi-misi') }}" class="hover:text-yellow-400">Visi & Misi</a></li>
          <li><a href="{{ route('pages.dosen') }}" class="hover:text-yellow-400">Dosen Pengajar</a></li>
          <li><a href="{{ route('pages.kurikulum') }}" class="hover:text-yellow-400">Unduh Kurikulum</a></li>
        </ul>
      </div>
      <div class="space-y-3">
        <h4 class="font-extrabold text-white text-xs uppercase tracking-wider">Kontak & Informasi</h4>
        <p class="text-gray-400">Jl. Cempaka 6, Wonoboyo, Wonogiri 57615</p>
        <p class="text-gray-400">WhatsApp: 082223204552</p>
      </div>
    </div>
    <div class="border-t border-teal-800 py-4 text-center text-[10px] text-gray-500">
      <p>© 2025 Program Studi Ekonomi Syariah STAIMAS Wonogiri. All Rights Reserved.</p>
    </div>
  </footer>




<script>
/* ── Scroll Reveal (Intersection Observer) ── */
(function () {
  const targets = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
  if (!targets.length) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });
  targets.forEach(el => io.observe(el));
})();

/* ── Auto attach .reveal to common elements ── */
(function () {
  setTimeout(() => {
    const selectors = [
      'main .bg-white:not(.no-reveal)',
      'main article',
      'main .grid > div',
      'main .grid > a',
      'main section > div',
    ];
    selectors.forEach(sel => {
      document.querySelectorAll(sel).forEach((el, i) => {
        if (!el.classList.contains('reveal') &&
            !el.classList.contains('reveal-left') &&
            !el.classList.contains('reveal-scale') &&
            !el.closest('.no-reveal')) {
          el.classList.add('reveal');
          if (i < 6) el.style.transitionDelay = (i * 0.05) + 's';
        }
      });
    });

    /* Re-run IO on newly tagged elements */
    const targets = document.querySelectorAll('.reveal:not(.visible), .reveal-left:not(.visible), .reveal-right:not(.visible), .reveal-scale:not(.visible)');
    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
    }, { threshold: 0.05 });
    targets.forEach(el => io.observe(el));
  }, 320);
})();
/* ── Intelligent Directed Page Slide Transition ── */
(function () {
  const wrapper = document.getElementById('page-wrapper');
  if (!wrapper) return;

  // List pathnames in order of header menu
  const menuOrder = [
    '/',
    '/visi-misi',
    '/dosen',
    '/kurikulum',
    '/berita'
  ];

  function getPathIndex(path) {
    if (path === '/' || path === '') return 0;
    // Check for partial match (like /berita/some-slug)
    for (let i = 0; i < menuOrder.length; i++) {
      if (menuOrder[i] !== '/' && path.startsWith(menuOrder[i])) {
        return i;
      }
    }
    return 0;
  }

  // 1. Play Entrance Animation based on stored direction
  const slideDir = sessionStorage.getItem('slide_dir');
  if (slideDir === 'left') {
    wrapper.classList.add('slide-from-left');
  } else if (slideDir === 'right') {
    wrapper.classList.add('slide-from-right');
  }
  sessionStorage.removeItem('slide_dir'); // clear after use

  // 2. Intercept local link clicks to detect direction
  document.addEventListener('click', function (e) {
    const a = e.target.closest('a');
    if (!a) return;
    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || a.target === '_blank') return;
    
    try {
      const url = new URL(href, location.href);
      if (url.host !== location.host) return;

      const currentIndex = getPathIndex(location.pathname);
      const targetIndex = getPathIndex(url.pathname);

      if (currentIndex === targetIndex && location.pathname === url.pathname) return;

      // Set target direction for the next page load
      if (targetIndex > currentIndex) {
        sessionStorage.setItem('slide_dir', 'right');
      } else {
        sessionStorage.setItem('slide_dir', 'left');
      }
    } catch (err) {}
  });
})();


/* ── Stat counter animation ── */
(function () {
  document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count, 10);
    const io = new IntersectionObserver(([entry]) => {
      if (!entry.isIntersecting) return;
      io.unobserve(el);
      let start = 0;
      const step = () => {
        start = Math.min(start + Math.ceil(target / 40), target);
        el.textContent = start;
        if (start < target) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    }, { threshold: 0.5 });
    io.observe(el);
  });
})();
</script>
</body>
</html>
