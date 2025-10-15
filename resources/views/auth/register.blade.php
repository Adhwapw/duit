@extends('layouts.auth')
@section('subtitle','Buat akun baru Anda')

@section('content')
<form method="POST" action="{{ route('register') }}" class="grid gap-3">
  @csrf
  <div>
    <label class="block text-sm mb-1">Nama</label>
    <input class="input" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @error('name')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Email</label>
    <input class="input" type="email" name="email" value="{{ old('email') }}" required>
    @error('email')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div class="grid sm:grid-cols-2 gap-3">
    <div>
      <label class="block text-sm mb-1">Kata sandi</label>
      <input class="input" type="password" name="password" required>
      @error('password')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="block text-sm mb-1">Konfirmasi</label>
      <input class="input" type="password" name="password_confirmation" required>
    </div>
  </div>
  <button class="btn-primary btn-lg w-full mt-1">Daftar</button>
</form>
<div class="mt-4 text-sm">Sudah punya akun? <a class="link" href="{{ route('login') }}">Masuk</a>.</div>
@endsection
