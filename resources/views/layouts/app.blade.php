<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Duit</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="text-slate-900">
  <nav class="navbar-grad sticky top-0 z-40 border-b border-white/50">
    <div class="container-app py-3 flex items-center justify-between">
      <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
        <span class="inline-flex items-center justify-center w-9 h-9 rounded-2xl bg-white shadow ring-1 ring-black/5">
          <!-- “D” logo minimal -->
          <span class="text-indigo-600 font-extrabold">D</span>
        </span>
        <span class="text-xl font-semibold">Duit</span>
      </a>
      @auth
      <div class="flex items-center gap-3">
        <a class="nav-link" href="{{ route('dompet.index') }}">Dompet</a>
        <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
        <a class="nav-link" href="{{ route('transaksi.index') }}">Transaksi</a>
        @if (Route::has('transfer.create'))
          <a class="nav-link" href="{{ route('transfer.create') }}">Transfer</a>
        @endif
        <a class="nav-link" href="{{ route('laporan.index') }}">Laporan</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn-ghost">Keluar</button>
        </form>
      </div>
      @else
      <div class="flex items-center gap-3">
        <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
        <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
      </div>
      @endauth
    </div>
  </nav>

  <main class="container-app py-6">
    @if(session('ok'))
      <div class="card mb-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-emerald-100">
        {{ session('ok') }}
      </div>
    @endif
    {{ $slot ?? '' }}
    @yield('content')
  </main>

  <footer class="container-app py-10 text-center text-sm text-slate-500">
    <div class="surface p-4">
      Dibuat dengan Laravel + Tailwind · Tema membulat ala Google Labs
    </div>
  </footer>
</body>
</html>
