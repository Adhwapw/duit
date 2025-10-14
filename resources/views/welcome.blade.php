<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Duit</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-white text-gray-900">
  <div class="max-w-4xl mx-auto px-4 py-16 text-center space-y-6">
    <h1 class="text-4xl font-bold">Duit</h1>
    <p class="text-gray-600">Catat pemasukan & pengeluaranmu dengan mudah.</p>
    <div class="flex justify-center gap-3">
      <a href="{{ route('register') }}" class="px-4 py-2 border rounded">Daftar</a>
      <a href="{{ route('login') }}" class="px-4 py-2 border rounded">Masuk</a>
    </div>
  </div>
</body>
</html>
