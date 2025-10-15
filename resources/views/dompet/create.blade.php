@extends('layouts.app')
@section('content')
<x-page-header title="Tambah Dompet" />
<form method="POST" action="{{ route('dompet.store') }}">
  @include('dompet._form')
</form>
@endsection
