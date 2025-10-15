@extends('layouts.app')
@section('content')
<x-page-header title="Edit Kategori" />
<form method="POST" action="{{ route('kategori.update', $kategori) }}">
  @method('PUT')
  @include('kategori._form', ['kategori'=>$kategori])
</form>
@endsection
