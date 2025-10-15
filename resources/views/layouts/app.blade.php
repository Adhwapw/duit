<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Duit</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
  {{-- NAVBAR RESPONSIVE --}}
  <nav class="navbar">
    <div class="container-app py-3 flex items-center justify-between">
      {{-- Brand --}}
      <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
        <span class="brand-badge"><span class="text-teal-600 font-extrabold text-lg">D</span></span>
        <span class="text-xl font-semibold">Duit</span>
      </a>

      {{-- Desktop links --}}
      @auth
        <div class="hidden md:flex items-center gap-4">
          <a class="link flex items-center gap-1" href="{{ route('dashboard') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="1.5" d="m3 9 9-6 9 6v10.5A1.5 1.5 0 0 1 19.5 21h-15A1.5 1.5 0 0 1 3 19.5V9Z"/></svg>
            Dashboard
          </a>
          <a class="link" href="{{ route('dompet.index') }}">Dompet</a>
          <a class="link" href="{{ route('kategori.index') }}">Kategori</a>
          <a class="link" href="{{ route('transaksi.index') }}">Transaksi</a>
          @if (Route::has('transfer.create'))
            <a class="link" href="{{ route('transfer.create') }}">Transfer</a>
          @endif
          <a class="link" href="{{ route('laporan.index') }}">Laporan</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn-ghost">Keluar</button>
          </form>
        </div>
      @else
        <div class="hidden md:flex items-center gap-3">
          <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
          <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
        </div>
      @endauth

      {{-- Mobile hamburger --}}
      <button
        id="nav-toggle"
        class="md:hidden inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-3 py-2"
        aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu" type="button">
        {{-- icon bars --}}
        <svg id="icon-bars" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16"/>
        </svg>
        {{-- icon close --}}
        <svg id="icon-x" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="1.5" d="M6 6l12 12M18 6l-12 12"/>
        </svg>
      </button>
    </div>

    {{-- Mobile menu panel --}}
    <div id="mobile-menu" class="hidden md:hidden border-t bg-white/95 backdrop-blur">
      <div class="container-app py-3 flex flex-col gap-2">
        @auth
          <a class="link" href="{{ route('dashboard') }}">Dashboard</a>
          <a class="link" href="{{ route('dompet.index') }}">Dompet</a>
          <a class="link" href="{{ route('kategori.index') }}">Kategori</a>
          <a class="link" href="{{ route('transaksi.index') }}">Transaksi</a>
          @if (Route::has('transfer.create'))
            <a class="link" href="{{ route('transfer.create') }}">Transfer</a>
          @endif
          <a class="link" href="{{ route('laporan.index') }}">Laporan</a>
          <form method="POST" action="{{ route('logout') }}" class="pt-1">
            @csrf
            <button class="btn-ghost w-full text-left">Keluar</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn-ghost w-full text-left">Masuk</a>
          <a href="{{ route('register') }}" class="btn-primary w-full">Daftar</a>
        @endauth
      </div>
    </div>
  </nav>

  {{-- MAIN --}}
  <main class="container-app py-6">
    @if(session('ok'))
      <div class="card-soft mb-4">{{ session('ok') }}</div>
    @endif
    {{ $slot ?? '' }}
    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer class="container-app py-10 text-center text-sm text-slate-500">
    <div class="card">Duit · Laravel | Dibuat dengan ❤️ oleh Kelompok 2</div>
  </footer>

  {{-- NAV TOGGLE SCRIPT (jalan setelah elemen ada) --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const btn  = document.getElementById('nav-toggle');
      const menu = document.getElementById('mobile-menu');
      const bars = document.getElementById('icon-bars');
      const x    = document.getElementById('icon-x');
      if (!btn || !menu) return;

      btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');                 // show/hide panel
        const open = !menu.classList.contains('hidden'); // state
        bars.classList.toggle('hidden', open);           // switch icon
        x.classList.toggle('hidden', !open);
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      });

      // Tutup saat resize ke desktop
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
          menu.classList.add('hidden');
          bars.classList.remove('hidden');
          x.classList.add('hidden');
          btn.setAttribute('aria-expanded','false');
        }
      });
    });
  </script>
</body>
</html>
