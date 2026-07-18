<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel – @yield('title', 'Dashboard') | Ekonomi Syariah STAIMAS</title>
  <link rel="icon" type="image/png" href="{{ asset('assest/LOGO STAIMAS AI.png') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f3f4f6; }
    /* Sidebar base */
    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 14px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: 500;
      color: #b2d8d8;
      text-decoration: none;
      transition: background 0.15s, color 0.15s;
      white-space: nowrap;
    }
    .sidebar-link:hover {
      background: rgba(255,255,255,0.10);
      color: #fff;
    }
    .sidebar-link.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
      font-weight: 700;
    }
    .sidebar-link i {
      width: 16px;
      text-align: center;
      font-size: 13px;
      opacity: 0.8;
      flex-shrink: 0;
    }
    .sidebar-link.active i { opacity: 1; }
    .sidebar-section-title {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: #5f9ea0;
      padding: 10px 14px 4px;
    }
    /* Flash messages */
    .flash-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 12px 16px; border-radius: 12px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
    .flash-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px 16px; border-radius: 12px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
    /* Responsive */
    @media (max-width: 768px) {
      #sidebar {
        position: fixed;
        top: 0; left: 0; bottom: 0;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
        z-index: 40;
      }
      #sidebar.open {
        transform: translateX(0);
      }
      #sidebar-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 39;
      }
      #sidebar-backdrop.open {
        display: block;
      }
      #burger-btn {
        display: flex;
      }
    }
  </style>
</head>
<body class="h-full bg-gray-100">
<div class="flex h-screen overflow-hidden">

  <!-- ═══ SIDEBAR ═══ -->
  <aside id="sidebar" class="w-60 bg-[#0d4f50] flex flex-col flex-shrink-0 overflow-y-auto">

    <!-- Logo -->
    <div class="px-4 py-5 border-b border-white/10">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-white rounded-xl border-2 border-yellow-700/50 flex items-center justify-center flex-shrink-0 overflow-hidden p-0.5">
          <img src="{{ asset('assest/LOGO STAIMAS AI.png') }}" alt="STAIMAS" class="w-full h-full object-contain">
        </div>
        <div>
          <div class="font-extrabold text-white text-sm leading-tight">ES STAIMAS</div>
          <div class="text-xs text-teal-300/50 font-bold uppercase tracking-widest">Admin Panel</div>
        </div>
      </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-2.5 py-3 flex flex-col gap-0.5">

      <div class="sidebar-section-title">Menu Utama</div>
      <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i>
        <span>Dashboard</span>
      </a>

      <div class="sidebar-section-title mt-2.5">Konten Website</div>
      <a href="{{ route('admin.slides.index') }}" class="sidebar-link {{ request()->routeIs('admin.slides*') ? 'active' : '' }}">
        <i class="fas fa-images"></i>
        <span>Hero Slider</span>
      </a>
      <a href="{{ route('admin.beritas.index') }}" class="sidebar-link {{ request()->routeIs('admin.beritas*') ? 'active' : '' }}">
        <i class="fas fa-newspaper"></i>
        <span>Berita</span>
      </a>
      <a href="{{ route('admin.kategoris.index') }}" class="sidebar-link {{ request()->routeIs('admin.kategoris*') ? 'active' : '' }}">
        <i class="fas fa-tags"></i>
        <span>Kategori Berita</span>
      </a>
      <a href="{{ route('admin.posters.index') }}" class="sidebar-link {{ request()->routeIs('admin.posters*') ? 'active' : '' }}">
        <i class="fas fa-flag"></i>
        <span>Poster & Pengumuman</span>
      </a>

      <div class="sidebar-section-title mt-2.5">Akademik</div>
      <a href="{{ route('admin.dosens.index') }}" class="sidebar-link {{ request()->routeIs('admin.dosens*') ? 'active' : '' }}">
        <i class="fas fa-user-tie"></i>
        <span>Dosen ES</span>
      </a>
    </nav>

    <!-- User & Logout -->
    <div class="px-2.5 py-3.5 border-t border-white/10">
      <div class="flex items-center gap-2.5 px-1.5 mb-2.5">
        <div class="w-8 h-8 bg-teal-800 rounded-lg flex items-center justify-center flex-shrink-0">
          <i class="fas fa-user text-yellow-500 text-xs"></i>
        </div>
        <div class="min-w-0">
          <div class="text-white text-xs font-bold truncate">{{ auth()->user()->name }}</div>
          <div class="text-teal-300/50 text-[10px] truncate">{{ auth()->user()->email }}</div>
        </div>
      </div>
      <form action="{{ route('admin.logout') }}" method="POST" class="mb-1.5">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-white/10 text-teal-200 text-xs font-semibold p-2 rounded-lg transition hover:bg-white/20">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
      <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-1.5 text-teal-300/50 text-[11px] no-underline p-1 transition hover:text-teal-200">
        <i class="fas fa-external-link-alt text-[9px]"></i> Lihat Website ES
      </a>
    </div>
  </aside>
  <div id="sidebar-backdrop" onclick="toggleSidebar()"></div>

  <!-- ═══ MAIN AREA ═══ -->
  <div class="flex-1 flex flex-col overflow-hidden min-w-0">

    <!-- Topbar -->
    <header class="bg-white border-b border-gray-200 px-4 sm:px-6 py-3.5 flex items-center justify-between flex-shrink-0">
      <div class="flex items-center gap-3">
        <button id="burger-btn" class="hidden items-center justify-center w-8 h-8 rounded-full text-gray-600 hover:bg-gray-100 hover:text-gray-800">
          <i class="fas fa-bars"></i>
        </button>
        <div>
          <h1 class="font-extrabold text-gray-800 text-lg m-0">@yield('title', 'Dashboard')</h1>
          @hasSection('breadcrumb')
          <p class="text-xs text-gray-400 m-0 mt-0.5">@yield('breadcrumb')</p>
          @endif
        </div>
      </div>
      <div class="flex items-center gap-2.5">
        @yield('header-action')
      </div>
    </header>

    <!-- Flash Messages -->
    <div class="px-4 sm:px-6 pt-4">
      @if(session('success'))
      <div class="flash-success"><i class="fas fa-check-circle text-green-600 flex-shrink-0"></i> {{ session('success') }}</div>
      @endif
      @if(session('error'))
      <div class="flash-error"><i class="fas fa-exclamation-circle text-red-500 flex-shrink-0"></i> {{ session('error') }}</div>
      @endif
      @if($errors->any())
      <div class="flash-error flex-col items-start">
        @foreach($errors->all() as $error)
        <div class="flex items-center gap-2"><i class="fas fa-times-circle text-red-500 flex-shrink-0"></i> {{ $error }}</div>
        @endforeach
      </div>
      @endif
    </div>

    <!-- Content -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 sm:pb-8">
      @yield('content')
    </main>

  </div>
</div>

<!-- ═══ DELETE CONFIRMATION MODAL ═══ -->
<div id="delete-modal" class="hidden fixed inset-0 z-[9999] items-center justify-center">
  <!-- Backdrop -->
  <div id="delete-backdrop" class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDeleteModal()"></div>

  <!-- Card -->
  <div id="delete-card" class="relative z-10 bg-white rounded-3xl p-8 max-w-sm w-[90%] shadow-2xl scale-90 opacity-0 transition-transform,opacity ease-out duration-200">
    <!-- Icon -->
    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
      <i class="fas fa-trash-alt text-red-500 text-2xl"></i>
    </div>

    <!-- Text -->
    <h3 class="text-center text-lg font-extrabold text-gray-800 m-0 mb-2">Hapus Data?</h3>
    <p id="delete-modal-msg" class="text-center text-sm text-gray-500 m-0 mb-7 leading-relaxed">
      Data yang dihapus tidak dapat dikembalikan lagi.
    </p>

    <!-- Buttons -->
    <div class="flex gap-3">
      <button onclick="closeDeleteModal()" class="flex-1 p-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-700 text-sm font-bold cursor-pointer transition hover:bg-gray-100">
        <i class="fas fa-times mr-1.5"></i>Batal
      </button>
      <button id="delete-confirm-btn" onclick="submitDeleteForm()" class="flex-1 p-3 rounded-xl border-none bg-red-600 text-white text-sm font-bold cursor-pointer transition hover:bg-red-700">
        <i class="fas fa-trash-alt mr-1.5"></i>Ya, Hapus!
      </button>
    </div>
  </div>
</div>

<script>
  // --- Sidebar Toggle ---
  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('sidebar-backdrop');
  const burgerBtn = document.getElementById('burger-btn');

  function toggleSidebar() {
    sidebar.classList.toggle('open');
    backdrop.classList.toggle('open');
  }

  burgerBtn.addEventListener('click', toggleSidebar);


  // --- Delete Modal ---
  let _deleteForm = null;

  function confirmDelete(formEl, label) {
    _deleteForm = formEl;
    const msg = label
      ? 'Yakin ingin menghapus <strong>"' + label + '"</strong>? Data tidak dapat dikembalikan.'
      : 'Data yang dihapus tidak dapat dikembalikan lagi.';
    document.getElementById('delete-modal-msg').innerHTML = msg;

    const modal = document.getElementById('delete-modal');
    const card  = document.getElementById('delete-card');
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
      card.style.transform  = 'scale(1) translateY(0)';
      card.style.opacity    = '1';
    });
  }

  function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    const card  = document.getElementById('delete-card');
    card.style.transform = 'scale(0.9) translateY(16px)';
    card.style.opacity   = '0';
    setTimeout(() => { modal.style.display = 'none'; }, 220);
    _deleteForm = null;
  }

  function submitDeleteForm() {
    if (_deleteForm) {
      const btn = document.getElementById('delete-confirm-btn');
      btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i>Menghapus...';
      btn.disabled = true;
      _deleteForm.submit();
    }
  }

  // Close on ESC
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
</script>

</body>
</html>