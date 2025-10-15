@extends('layouts.app')
@section('content')
<x-page-header title="Edit Dompet" />
<form method="POST" action="{{ route('dompet.update', $dompet) }}">
  @method('PUT')
  @include('dompet._form', ['dompet'=>$dompet])
</form>
@endsection
