@extends('layouts.app')
@section('content')
<x-page-header title="Tambah Kategori" />
<form method="POST" action="{{ route('kategori.store') }}">
  @include('kategori._form')
</form>
@endsection
