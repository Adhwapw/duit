<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Duit</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="auth-bg">
  <div class="container-app py-16">
    <div class="max-w-4xl mx-auto text-center space-y-6">
      <div class="inline-flex items-center gap-3">
        <span class="brand-badge"><span class="text-teal-600 font-extrabold text-lg">D</span></span>
        <h1 class="text-4xl font-bold">Duit</h1>
      </div>
      <p class="text-slate-600">Kelola keuangan pribadi dengan cepat, catat transaksi, pantau saldo, dan unduh laporan.</p>

      <div class="grid sm:grid-cols-3 gap-4 text-left">
        <div class="card-soft">
          <div class="muted text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M3 5.25h18V18.75H3V5.25Zm3 3h6V12H6V8.25Z"/></svg>
            Pencatatan
          </div>
          <div class="font-semibold mt-1">Tambah Transaksi Cepat</div>
        </div>
        <div class="card-soft-blue">
          <div class="muted text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 3.75h15v16.5h-15V3.75Z"/></svg>
            Ringkasan
          </div>
          <div class="font-semibold mt-1">Pantau Saldo & Grafik</div>
        </div>
        <div class="card-soft-amber">
          <div class="muted text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 6h15v12h-15V6Z"/></svg>
            Laporan
          </div>
          <div class="font-semibold mt-1">Filter & Unduh CSV</div>
        </div>
      </div>

      <div class="flex justify-center gap-3">
        <a href="{{ route('register') }}" class="btn-primary btn-lg">Mulai Daftar</a>
        <a href="{{ route('login') }}" class="btn-ghost btn-lg">Saya sudah punya akun</a>
      </div>
    </div>
  </div>
</body>
</html>
