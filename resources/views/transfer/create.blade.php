@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-6">Transfer Antar Dompet</h1>

<form method="POST" action="{{ route('transfer.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
  @csrf

  <div>
    <label class="block text-sm mb-1">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="w-full border rounded px-3 py-2">
    @error('tanggal')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Jumlah</label>
    <input type="number" step="0.01" min="0.01" name="jumlah" value="{{ old('jumlah') }}" class="w-full border rounded px-3 py-2" placeholder="0.00">
    @error('jumlah')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Dari Dompet</label>
    <select name="sumber_dompet_id" class="w-full border rounded px-3 py-2">
      @foreach($dompet as $d)
        <option value="{{ $d->id }}" @selected(old('sumber_dompet_id')==$d->id)>{{ $d->nama_dompet }} ({{ $d->jenis_dompet }})</option>
      @endforeach
    </select>
    @error('sumber_dompet_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm mb-1">Ke Dompet</label>
    <select name="tujuan_dompet_id" class="w-full border rounded px-3 py-2">
      @foreach($dompet as $d)
        <option value="{{ $d->id }}" @selected(old('tujuan_dompet_id')==$d->id)>{{ $d->nama_dompet }} ({{ $d->jenis_dompet }})</option>
      @endforeach
    </select>
    @error('tujuan_dompet_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>

  <div class="md:col-span-2">
    <label class="block text-sm mb-1">Catatan (opsional)</label>
    <input name="catatan" value="{{ old('catatan') }}" class="w-full border rounded px-3 py-2" placeholder="mis. pindah saldo ke rekening">
  </div>

  <div class="md:col-span-2 flex gap-2">
    <button class="px-4 py-2 border rounded">Simpan Transfer</button>
    <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded">Batal</a>
  </div>
</form>
@endsection
