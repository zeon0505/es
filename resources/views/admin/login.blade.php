<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin – Ekonomi Syariah STAIMAS Wonogiri</title>
  <link rel="icon" type="image/png" href="{{ asset('assest/LOGO STAIMAS AI.png') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  @vite(['resources/css/app.css'])
  <style>body{font-family:'Plus Jakarta Sans',sans-serif;}</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-teal-950 via-teal-900 to-teal-800 flex items-center justify-center p-4">

  <div class="w-full max-w-md">
    <!-- Logo -->
    <div class="text-center mb-8 space-y-2">
      <div class="w-20 h-20 mx-auto bg-white rounded-2xl border-2 border-yellow-500/50 flex items-center justify-center shadow-xl overflow-hidden p-1">
        <img src="{{ asset('assest/LOGO STAIMAS AI.png') }}" alt="STAIMAS Logo" class="w-full h-full object-contain">
      </div>
      <h1 class="text-white font-black text-2xl">Admin Panel Ekonomi Syariah</h1>
      <p class="text-teal-300 text-sm">STAIMAS Wonogiri – Restricted Access</p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 space-y-5">
      @if(session('error'))
      <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
      </div>
      @endif

      <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
        @csrf
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Email Admin</label>
          <div class="relative">
            <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="email" name="email" value="{{ old('email') }}" required
              class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('email') border-red-400 @enderror"
              placeholder="Email">
          </div>
          @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-gray-700">Password</label>
          <div class="relative">
            <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="password" name="password" required
              class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
              placeholder="••••••••">
          </div>
        </div>

        <button type="submit" class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold py-3.5 rounded-xl shadow transition-all flex items-center justify-center gap-2 text-sm">
          <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
        </button>
      </form>

      <p class="text-center text-xs text-gray-400">Halaman ini tidak ditampilkan di website publik.</p>
    </div>

    <p class="text-center text-teal-500 text-xs mt-6">© 2026 Ekonomi Syariah STAIMAS Wonogiri</p>
  </div>

</body>
</html>
