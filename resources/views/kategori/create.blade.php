@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Tambah Kategori</h1>
<form method="POST" action="{{ route('kategori.store') }}">
  @include('kategori._form')
</form>
@endsection
