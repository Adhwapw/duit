<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Duit</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-white text-gray-900">
  <nav class="border-b bg-white sticky top-0">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="{{ route('dashboard') }}" class="text-xl font-semibold">Duit</a>
      <div class="flex items-center gap-4">
        <a class="hover:underline" href="{{ route('dompet.index') }}">Dompet</a>
        <a class="hover:underline" href="{{ route('kategori.index') }}">Kategori</a>
        <a class="hover:underline" href="{{ route('transaksi.index') }}">Transaksi</a>
        <a class="hover:underline" href="{{ route('laporan.index') }}">Laporan</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="px-3 py-1 rounded border">Keluar</button>
        </form>
      </div>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto px-4 py-6">
    @if(session('ok'))
      <div class="mb-4 p-3 rounded bg-green-50 border border-green-200">{{ session('ok') }}</div>
    @endif
    {{ $slot ?? '' }}
    @yield('content')
  </main>
</body>
</html>
