@extends('layouts.auth')
@section('subtitle','Masuk ke akun Anda')

@section('content')
@if (session('status'))
  <div class="mb-3 p-3 rounded-xl bg-green-50 border border-green-200 text-sm">{{ session('status') }}</div>
@endif
<form method="POST" action="{{ route('login') }}" class="grid gap-3">
  @csrf
  <div>
    <label class="block text-sm mb-1">Email</label>
    <input class="input" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @error('email')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Kata sandi</label>
    <input class="input" type="password" name="password" required>
    @error('password')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div class="flex items-center justify-between">
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" class="rounded border-slate-300"> Ingat saya</label>
    @if (Route::has('password.request'))<a class="link text-sm" href="{{ route('password.request') }}">Lupa kata sandi?</a>@endif
  </div>
  <button class="btn-primary btn-lg w-full mt-1">Masuk</button>
</form>
<div class="mt-4 text-sm">Belum punya akun? <a class="link" href="{{ route('register') }}">Daftar sekarang</a>.</div>
@endsection
