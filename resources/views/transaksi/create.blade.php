@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Tambah Transaksi</h1>
<form method="POST" action="{{ route('transaksi.store') }}">
  @include('transaksi._form', ['dompet'=>$dompet, 'kategori'=>$kategori])
</form>
@endsection
