@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Tambah Dompet</h1>
<form method="POST" action="{{ route('dompet.store') }}">
  @include('dompet._form')
</form>
@endsection
