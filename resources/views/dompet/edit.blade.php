@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Dompet</h1>
<form method="POST" action="{{ route('dompet.update', $dompet) }}">
  @method('PUT')
  @include('dompet._form', ['dompet'=>$dompet])
</form>
@endsection
