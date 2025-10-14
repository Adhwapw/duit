@extends('layouts.app')
@section('content')
<div class="mb-4 flex items-center justify-between">
  <h1 class="text-2xl font-semibold">Transaksi</h1>
  <a href="{{ route('transaksi.create') }}" class="btn-primary">Tambah</a>
</div>

{{-- FILTER & SEARCH --}}
<form method="GET" class="card mb-4 grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
  <div class="md:col-span-2">
    <label class="block text-sm mb-1 text-slate-700">Cari (catatan / dompet / kategori)</label>
    <input type="text" name="q" value="{{ $q }}" placeholder="mis: makan / BCA / gaji" class="input">
  </div>
  <div>
    <label class="block text-sm mb-1 text-slate-700">Jenis</label>
    <select name="jenis" class="select">
      <option value="">-- semua --</option>
      <option value="pemasukan" {{ $jenis==='pemasukan' ? 'selected' : '' }}>pemasukan</option>
      <option value="pengeluaran" {{ $jenis==='pengeluaran' ? 'selected' : '' }}>pengeluaran</option>
    </select>
  </div>
  <div>
    <label class="block text-sm mb-1 text-slate-700">Tanggal Awal</label>
    <input type="date" name="awal" value="{{ $awal }}" class="input">
  </div>
  <div>
    <label class="block text-sm mb-1 text-slate-700">Tanggal Akhir</label>
    <input type="date" name="akhir" value="{{ $akhir }}" class="input">
  </div>
  <div class="md:col-span-5 flex gap-2">
    <button class="btn-ghost">Terapkan</button>
    <a href="{{ route('transaksi.index') }}" class="btn-ghost">Reset</a>
  </div>
</form>

<x-tabel>
  <thead>
    <tr>
      <th class="th">Tanggal</th>
      <th class="th">Jenis</th>
      <th class="th">Dompet</th>
      <th class="th">Kategori</th>
      <th class="th text-right">Jumlah</th>
      <th class="th">Catatan</th>
      <th class="th text-right">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $t)
    <tr>
      <td class="td">{{ $t->tanggal }}</td>
      <td class="td">
        @if($t->jenis === 'pemasukan')
          <span class="pill pill-green">pemasukan</span>
        @else
          <span class="pill pill-rose">pengeluaran</span>
        @endif
      </td>
      <td class="td">{{ $t->dompet?->nama_dompet }}</td>
      <td class="td">{{ $t->kategori?->nama_kategori }}</td>
      <td class="td text-right font-semibold">{{ number_format($t->jumlah,2,',','.') }}</td>
      <td class="td">{{ $t->catatan }}</td>
      <td class="td text-right">
        <a class="btn-ghost" href="{{ route('transaksi.edit',$t) }}">Edit</a>
        <form class="inline" method="POST" action="{{ route('transaksi.destroy',$t) }}">
          @csrf @method('DELETE')
          <button class="btn-danger" onclick="return confirm('Hapus transaksi?')">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td class="td" colspan="7">Tidak ada data untuk filter ini.</td></tr>
    @endforelse
  </tbody>
</x-tabel>

<div class="mt-4">
  {{ $items->withQueryString()->links() }}
</div>
@endsection
