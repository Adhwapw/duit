@extends('layouts.app')

@section('content')
<x-page-header title="Transfer Antar Dompet" subtitle="Pindahkan saldo antar dompet Anda">
  <a href="{{ route('transaksi.index') }}" class="btn-ghost">
    {{-- list icon --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6h16v2H4V6Zm0 5h10v2H4v-2Zm0 5h16v2H4v-2Z"/></svg>
    Lihat Transaksi
  </a>
</x-page-header>

{{-- Tips kecil --}}
<div class="card-soft mb-4 text-sm">
  <div class="flex items-start gap-2">
    {{-- info icon --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.25a9.75 9.75 0 1 0 0 19.5 9.75 9.75 0 0 0 0-19.5Zm.75 5.25v2.25h-1.5V7.5h1.5ZM10.5 10.5h3v6h-3v-6Z"/></svg>
    <p>
      Transfer akan mencatat <b>2 transaksi otomatis</b>: <i>pengeluaran</i> pada dompet sumber dan <i>pemasukan</i> pada dompet tujuan.
      Pastikan dompet sumber & tujuan <b>berbeda</b>.
    </p>
  </div>
</div>

<form method="POST" action="{{ route('transfer.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
  @csrf

  <div class="card-soft">
    <label class="block text-sm mb-1">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="input">
    @error('tanggal')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="card-soft">
    <label class="block text-sm mb-1">Jumlah</label>
    <div class="flex items-center gap-2">
      {{-- currency icon --}}
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3.75c4.556 0 8.25 3.694 8.25 8.25S16.556 20.25 12 20.25 3.75 16.556 3.75 12 7.444 3.75 12 3.75Zm.75 3.75h-1.5v1.2a3.3 3.3 0 0 0-2.7 3.24h1.5a1.8 1.8 0 0 1 1.8-1.8h.9a1.5 1.5 0 0 1 0 3h-.9a3.3 3.3 0 0 0 0 6.6h.9v1.2h1.5v-1.2a3.3 3.3 0 0 0 2.7-3.24h-1.5a1.8 1.8 0 0 1-1.8 1.8h-.9a1.8 1.8 0 1 1 0-3.6h.9a3 3 0 1 0 0-6h-.9V7.5Z"/></svg>
      <input type="number" step="0.01" min="0.01" name="jumlah" value="{{ old('jumlah') }}" class="input" placeholder="0.00">
    </div>
    @error('jumlah')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="card-soft">
    <label class="block text-sm mb-1">Dari Dompet (Sumber)</label>
    <select id="sumber_dompet_id" name="sumber_dompet_id" class="select">
      @foreach($dompet as $d)
        <option value="{{ $d->id }}" @selected(old('sumber_dompet_id')==$d->id)>{{ $d->nama_dompet }} ({{ $d->jenis_dompet }})</option>
      @endforeach
    </select>
    @error('sumber_dompet_id')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="card-soft">
    <label class="block text-sm mb-1">Ke Dompet (Tujuan)</label>
    <select id="tujuan_dompet_id" name="tujuan_dompet_id" class="select">
      @foreach($dompet as $d)
        <option value="{{ $d->id }}" @selected(old('tujuan_dompet_id')==$d->id)>{{ $d->nama_dompet }} ({{ $d->jenis_dompet }})</option>
      @endforeach
    </select>
    @error('tujuan_dompet_id')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="md:col-span-2 card-soft">
    <label class="block text-sm mb-1">Catatan (opsional)</label>
    <input name="catatan" value="{{ old('catatan') }}" class="input" placeholder="mis. pindah saldo ke rekening utama">
  </div>

  <div class="md:col-span-2 flex gap-2 justify-end">
    <button class="btn-primary">
      {{-- arrow-right-left icon --}}
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="1.5" d="M7.5 7.5 3 12l4.5 4.5M21 12H3m13.5-4.5L21 12l-4.5 4.5"/></svg>
      Simpan Transfer
    </button>
    <a href="{{ route('dashboard') }}" class="btn-ghost">Batal</a>
  </div>
</form>

{{-- Validasi UX ringan: cegah pilihan dompet yang sama (client-side) --}}
<script>
  (function(){
    const s = document.getElementById('sumber_dompet_id');
    const t = document.getElementById('tujuan_dompet_id');
    if (!s || !t) return;
    function guardSame(){
      if (s.value === t.value) {
        t.setCustomValidity('Dompet tujuan harus berbeda dengan dompet sumber.');
      } else {
        t.setCustomValidity('');
      }
    }
    s.addEventListener('change', guardSame);
    t.addEventListener('change', guardSame);
    guardSame();
  })();
</script>
@endsection
