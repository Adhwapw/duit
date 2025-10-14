@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Transaksi</h1>
<form method="POST" action="{{ route('transaksi.update', $transaksi) }}">
  @method('PUT')
  @include('transaksi._form', ['transaksi'=>$transaksi, 'dompet'=>$dompet, 'kategori'=>$kategori])
</form>
@endsection
