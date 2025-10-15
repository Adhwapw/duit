<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Duit – Autentikasi</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="auth-bg">
  <div class="container-app auth-shell">
    <div class="auth-card">
      <div class="flex items-center gap-3 mb-4">
        <span class="brand-badge"><span class="text-teal-600 font-extrabold text-lg">D</span></span>
        <div>
          <div class="text-2xl font-bold">Duit</div>
          <div class="text-sm text-slate-600">@yield('subtitle','')</div>
        </div>
      </div>

      @yield('content')

      <p class="text-xs text-slate-500 mt-4">Dengan masuk/daftar, Anda menyetujui pengelolaan data transaksi pada akun Anda.</p>
    </div>
  </div>
</body>
</html>
