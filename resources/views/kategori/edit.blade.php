@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Kategori</h1>
<form method="POST" action="{{ route('kategori.update', $kategori) }}">
  @method('PUT')
  @include('kategori._form', ['kategori'=>$kategori])
</form>
@endsection
